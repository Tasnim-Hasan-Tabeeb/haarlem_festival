# Date-Driven Dance Tickets Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Render dance performances and day passes from database dates, place one all-round pass after all dated sections, and purchase passes by unique ID.

**Architecture:** Add a pure `DancePageDataBuilder` that groups ordered performance rows and pass rows into view-ready date sections. Keep database access in `DanceRepository`, orchestration in `DanceService`, and rendering in a testable tickets partial. Preserve the existing `passType` basket field for checkout compatibility while using `pass_scope`, `event_date`, and `pass_id` for page behavior and lookup.

**Tech Stack:** PHP 8.3, PDO/MariaDB, server-rendered PHP views, jQuery AJAX, a lightweight project-local PHP test runner.

---

## File Map

- Create `app/tests/bootstrap.php`: minimal assertions and test registration.
- Create `app/tests/run.php`: runs all application tests without adding a dependency.
- Create `app/tests/DancePageDataBuilderTest.php`: grouping, sorting, matching, and all-round-pass tests.
- Create `app/tests/DanceTicketsViewTest.php`: dynamic HTML ordering and empty-state tests.
- Create `app/tests/DanceServiceTest.php`: pass lookup by ID and unknown-ID behavior.
- Create `app/tests/DatabaseSchemaTest.php`: verifies the SQL dump contains the new pass metadata and backfill.
- Create `app/services/DancePageDataBuilder.php`: pure transformation from repository rows to page data.
- Create `app/views/frontend/dance/tickets.php`: date-section and all-round-pass markup.
- Modify `festivaldb_new.sql`: add and seed `event_date` and `pass_scope`.
- Modify `app/repositories/DanceRepository.php`: ordered active events and pass lookup by ID.
- Modify `app/services/DanceService.php`: injectable dependencies, page-data orchestration, and pass creation by ID.
- Modify `app/controllers/HomeController.php`: consume `danceDays` and `allDatesPass`.
- Modify `app/views/frontend/dance/index.php`: include the dynamic tickets partial and post `pass_id`.
- Modify `app/models/TicketPass.php`: carry scope/date while preserving basket compatibility.

### Task 1: Add The Test Harness And Date Grouping

**Files:**
- Create: `app/tests/bootstrap.php`
- Create: `app/tests/run.php`
- Create: `app/tests/DancePageDataBuilderTest.php`
- Create: `app/services/DancePageDataBuilder.php`

- [ ] **Step 1: Create the lightweight test harness**

Create `app/tests/bootstrap.php`:

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$tests = [];

function test(string $name, callable $callback): void
{
    global $tests;
    $tests[$name] = $callback;
}

function assertSameValue(mixed $expected, mixed $actual): void
{
    if ($expected !== $actual) {
        throw new RuntimeException(
            'Expected ' . var_export($expected, true) . ', got ' . var_export($actual, true)
        );
    }
}

function assertContainsText(string $needle, string $haystack): void
{
    if (!str_contains($haystack, $needle)) {
        throw new RuntimeException("Expected output to contain: {$needle}");
    }
}

function assertNotContainsText(string $needle, string $haystack): void
{
    if (str_contains($haystack, $needle)) {
        throw new RuntimeException("Expected output not to contain: {$needle}");
    }
}
```

Create `app/tests/run.php`:

```php
<?php

require __DIR__ . '/bootstrap.php';

foreach (glob(__DIR__ . '/*Test.php') as $testFile) {
    require $testFile;
}

$failures = 0;

foreach ($tests as $name => $callback) {
    try {
        $callback();
        echo "PASS {$name}\n";
    } catch (Throwable $throwable) {
        $failures++;
        echo "FAIL {$name}: {$throwable->getMessage()}\n";
    }
}

exit($failures === 0 ? 0 : 1);
```

- [ ] **Step 2: Write failing grouping tests**

Create `app/tests/DancePageDataBuilderTest.php`:

```php
<?php

use App\Services\DancePageDataBuilder;

test('groups performances by date in chronological order', function (): void {
    $builder = new DancePageDataBuilder();
    $result = $builder->build(
        [
            ['music_event_id' => 3, 'event_name' => 'Sunday Set', 'event_date' => '2026-08-02', 'event_start_time' => '21:00:00'],
            ['music_event_id' => 1, 'event_name' => 'Late Friday Set', 'event_date' => '2026-07-31', 'event_start_time' => '23:00:00'],
            ['music_event_id' => 2, 'event_name' => 'Early Friday Set', 'event_date' => '2026-07-31', 'event_start_time' => '20:00:00'],
        ],
        []
    );

    assertSameValue(['2026-07-31', '2026-08-02'], array_column($result['danceDays'], 'date'));
    assertSameValue(
        ['Early Friday Set', 'Late Friday Set'],
        array_column($result['danceDays'][0]['tickets'], 'event_name')
    );
    assertSameValue('Friday', $result['danceDays'][0]['weekday']);
    assertSameValue('31 July 2026', $result['danceDays'][0]['formattedDate']);
});

test('matches day passes by exact date and separates the all-round pass', function (): void {
    $builder = new DancePageDataBuilder();
    $result = $builder->build(
        [
            ['music_event_id' => 1, 'event_name' => 'Friday Set', 'event_date' => '2026-07-31', 'event_start_time' => '20:00:00'],
            ['music_event_id' => 2, 'event_name' => 'Sunday Set', 'event_date' => '2026-08-02', 'event_start_time' => '21:00:00'],
        ],
        [
            ['pass_id' => 10, 'passName' => 'Friday Pass', 'pass_scope' => 'day', 'event_date' => '2026-07-31'],
            ['pass_id' => 11, 'passName' => 'All-Round Pass', 'pass_scope' => 'all_dates', 'event_date' => null],
        ]
    );

    assertSameValue(10, $result['danceDays'][0]['dayPass']['pass_id']);
    assertSameValue(null, $result['danceDays'][1]['dayPass']);
    assertSameValue(11, $result['allDatesPass']['pass_id']);
});

test('a newly added performance date creates another section', function (): void {
    $builder = new DancePageDataBuilder();
    $result = $builder->build(
        [
            ['music_event_id' => 1, 'event_name' => 'First Set', 'event_date' => '2026-07-31', 'event_start_time' => '20:00:00'],
            ['music_event_id' => 2, 'event_name' => 'New Date Set', 'event_date' => '2026-08-03', 'event_start_time' => '20:00:00'],
        ],
        []
    );

    assertSameValue(2, count($result['danceDays']));
    assertSameValue('2026-08-03', $result['danceDays'][1]['date']);
});
```

- [ ] **Step 3: Run the test and verify RED**

Run:

```powershell
php app/tests/run.php
```

Expected: FAIL because `App\Services\DancePageDataBuilder` does not exist.

- [ ] **Step 4: Implement the minimal builder**

Create `app/services/DancePageDataBuilder.php`:

```php
<?php

namespace App\Services;

use DateTimeImmutable;

class DancePageDataBuilder
{
    public function build(array $events, array $passes): array
    {
        usort($events, static function (array $left, array $right): int {
            return [$left['event_date'], $left['event_start_time']]
                <=> [$right['event_date'], $right['event_start_time']];
        });

        $dayPasses = [];
        $allDatesPass = null;

        foreach ($passes as $pass) {
            if ($pass['pass_scope'] === 'all_dates') {
                $allDatesPass ??= $pass;
                continue;
            }

            if ($pass['pass_scope'] === 'day' && !empty($pass['event_date'])) {
                $dayPasses[$pass['event_date']] = $pass;
            }
        }

        $days = [];

        foreach ($events as $event) {
            $date = $event['event_date'];

            if (!isset($days[$date])) {
                $dateValue = new DateTimeImmutable($date);
                $days[$date] = [
                    'date' => $date,
                    'weekday' => $dateValue->format('l'),
                    'formattedDate' => $dateValue->format('j F Y'),
                    'dayPass' => $dayPasses[$date] ?? null,
                    'tickets' => [],
                ];
            }

            $days[$date]['tickets'][] = $event;
        }

        return [
            'danceDays' => array_values($days),
            'allDatesPass' => $allDatesPass,
        ];
    }
}
```

- [ ] **Step 5: Run the test and verify GREEN**

Run:

```powershell
php app/tests/run.php
```

Expected: all three builder tests PASS.

- [ ] **Step 6: Commit**

```powershell
git add app/tests app/services/DancePageDataBuilder.php
git commit -m "test: cover date-driven dance grouping"
```

### Task 2: Return Ordered Page Data From The Service

**Files:**
- Modify: `app/repositories/DanceRepository.php`
- Modify: `app/services/DanceService.php`
- Modify: `app/controllers/HomeController.php`
- Create: `app/tests/DanceServiceTest.php`

- [ ] **Step 1: Write a failing service orchestration test**

Create `app/tests/DanceServiceTest.php`:

```php
<?php

use App\Repositories\DanceRepository;
use App\Services\DancePageDataBuilder;
use App\Services\DanceService;

class FakeDancePageRepository extends DanceRepository
{
    public function __construct()
    {
    }

    public function getActiveEvents()
    {
        return [
            ['music_event_id' => 1, 'event_name' => 'Friday Set', 'event_date' => '2026-07-31', 'event_start_time' => '20:00:00'],
        ];
    }

    public function getAllPasses()
    {
        return [
            ['pass_id' => 5, 'passName' => 'Friday Pass', 'pass_scope' => 'day', 'event_date' => '2026-07-31'],
        ];
    }
}

test('dance service builds page data from active events and passes', function (): void {
    $service = new DanceService(new FakeDancePageRepository(), new DancePageDataBuilder());
    $result = $service->getDancePageData();

    assertSameValue('Friday Set', $result['danceDays'][0]['tickets'][0]['event_name']);
    assertSameValue(5, $result['danceDays'][0]['dayPass']['pass_id']);
});
```

- [ ] **Step 2: Run the test and verify RED**

Run:

```powershell
php app/tests/run.php
```

Expected: FAIL because `DanceService` does not accept injected dependencies and has no `getDancePageData()`.

- [ ] **Step 3: Add dependency injection and page-data orchestration**

Change the constructor and add the method in `app/services/DanceService.php`:

```php
private DanceRepository $danceRepository;
private DancePageDataBuilder $pageDataBuilder;

public function __construct(
    ?DanceRepository $danceRepository = null,
    ?DancePageDataBuilder $pageDataBuilder = null
) {
    $this->danceRepository = $danceRepository ?? new DanceRepository();
    $this->pageDataBuilder = $pageDataBuilder ?? new DancePageDataBuilder();
}

public function getDancePageData(): array
{
    try {
        return $this->pageDataBuilder->build(
            $this->danceRepository->getActiveEvents(),
            $this->danceRepository->getAllPasses()
        );
    } catch (Exception $e) {
        throw new Exception('Error: ' . $e->getMessage());
    }
}
```

No import is needed for `DancePageDataBuilder` because it shares the `App\Services` namespace.

- [ ] **Step 4: Order active events in the repository**

Update `getActiveEvents()` in `app/repositories/DanceRepository.php`:

```php
$sql = $this->baseEventQuery() . '
    WHERE me.event_date >= CURDATE()
    GROUP BY mp.music_event_id
    ORDER BY me.event_date ASC, me.event_start_time ASC
';
```

Also fix `getEventsByDate()` so a retained public method is not silently wrong:

```php
$sql = $this->baseEventQuery() . '
    WHERE me.event_date = :event_date
    GROUP BY mp.music_event_id
    ORDER BY me.event_start_time ASC
';
```

- [ ] **Step 5: Replace weekday-specific controller data**

Replace `loadDancePage()` in `app/controllers/HomeController.php`:

```php
private function loadDancePage()
{
    $dancePageData = $this->danceService->getDancePageData();

    return View::make('frontend/dance/index', [
        'artists' => $this->artistService->getAllArtists(),
        'venues' => $this->venueService->getAllVenues(),
        'danceDays' => $dancePageData['danceDays'],
        'allDatesPass' => $dancePageData['allDatesPass'],
        'title' => 'Dance',
    ]);
}
```

Delete the now-unused private `groupPasses()` method. Keep the old weekday methods in repository/service temporarily if other code references them; `rg` must confirm they are unused before removing them in Task 5.

- [ ] **Step 6: Run tests and PHP syntax checks**

Run:

```powershell
php app/tests/run.php
php -l app/services/DanceService.php
php -l app/repositories/DanceRepository.php
php -l app/controllers/HomeController.php
```

Expected: all tests PASS and each syntax check reports no errors.

- [ ] **Step 7: Commit**

```powershell
git add app/tests/DanceServiceTest.php app/services/DanceService.php app/repositories/DanceRepository.php app/controllers/HomeController.php
git commit -m "feat: build dance page data from event dates"
```

### Task 3: Add Pass Scope And Date To The Database Dump

**Files:**
- Create: `app/tests/DatabaseSchemaTest.php`
- Modify: `festivaldb_new.sql`

- [ ] **Step 1: Write a failing SQL dump test**

Create `app/tests/DatabaseSchemaTest.php`:

```php
<?php

test('ticket passes store date and scope metadata', function (): void {
    $sql = file_get_contents(__DIR__ . '/../../festivaldb_new.sql');

    assertContainsText('`event_date` date DEFAULT NULL', $sql);
    assertContainsText("`pass_scope` enum('day','all_dates') NOT NULL", $sql);
    assertContainsText("'2026-06-27', 'day'", $sql);
    assertContainsText("'2026-07-31', 'day'", $sql);
    assertContainsText("'2026-08-02', 'day'", $sql);
    assertContainsText("NULL, 'all_dates'", $sql);
});
```

- [ ] **Step 2: Run the test and verify RED**

Run:

```powershell
php app/tests/run.php
```

Expected: FAIL because the `ticket_pass` table lacks both columns.

- [ ] **Step 3: Update the table and seed rows**

Change the `ticket_pass` table in `festivaldb_new.sql`:

```sql
CREATE TABLE `ticket_pass` (
  `pass_id` int(11) NOT NULL,
  `passName` varchar(255) DEFAULT NULL,
  `passDescription` text DEFAULT NULL,
  `passPrice` decimal(10,2) DEFAULT NULL,
  `passType` varchar(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `pass_scope` enum('day','all_dates') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
```

Replace its insert with:

```sql
INSERT INTO `ticket_pass`
(`pass_id`, `passName`, `passDescription`, `passPrice`, `passType`, `event_date`, `pass_scope`) VALUES
(1, 'Saturday Dance Pass', 'Access to all Haarlem Festival dance events on Saturday 27 June 2026.', 79.00, 'Day Pass', '2026-06-27', 'day'),
(2, 'Sunday Dance Pass', 'Access to all Haarlem Festival dance events on Sunday 2 August 2026.', 79.00, 'Day Pass', '2026-08-02', 'day'),
(3, 'All-Round Dance Pass', 'Access to every date that currently has a Haarlem Festival dance performance.', 199.00, 'All-Round Pass', NULL, 'all_dates'),
(4, 'Friday Dance Pass', 'Access to all Haarlem Festival dance events on Friday 31 July 2026.', 79.00, 'Day Pass', '2026-07-31', 'day');
```

- [ ] **Step 4: Run the schema test**

Run:

```powershell
php app/tests/run.php
```

Expected: all tests PASS.

- [ ] **Step 5: Apply the equivalent migration to an existing local database**

When the containers are running, execute:

```powershell
docker compose exec mysql mariadb -uprodevs -pnerds!1234 festivaldb -e "ALTER TABLE ticket_pass ADD COLUMN event_date DATE NULL AFTER passType, ADD COLUMN pass_scope ENUM('day','all_dates') NOT NULL DEFAULT 'day' AFTER event_date; UPDATE ticket_pass SET event_date = CASE pass_id WHEN 1 THEN '2026-06-27' WHEN 2 THEN '2026-08-02' WHEN 4 THEN '2026-07-31' ELSE NULL END, pass_scope = CASE WHEN pass_id = 3 THEN 'all_dates' ELSE 'day' END; UPDATE ticket_pass SET passName = 'All-Round Dance Pass', passType = 'All-Round Pass', passDescription = 'Access to every date that currently has a Haarlem Festival dance performance.' WHERE pass_id = 3;"
```

Expected: command exits successfully. If the local database is recreated from `festivaldb_new.sql` instead, skip this command and import the updated dump.

- [ ] **Step 6: Commit**

```powershell
git add app/tests/DatabaseSchemaTest.php festivaldb_new.sql
git commit -m "feat: add date metadata to dance passes"
```

### Task 4: Render Dynamic Date Sections And The Final All-Round Pass

**Files:**
- Create: `app/tests/DanceTicketsViewTest.php`
- Create: `app/views/frontend/dance/tickets.php`
- Modify: `app/views/frontend/dance/index.php`

- [ ] **Step 1: Write failing view tests**

Create `app/tests/DanceTicketsViewTest.php`:

```php
<?php

function renderDanceTickets(array $danceDays, ?array $allDatesPass): string
{
    ob_start();
    require __DIR__ . '/../views/frontend/dance/tickets.php';
    return ob_get_clean();
}

function sampleTicket(string $name, string $date): array
{
    return [
        'music_performance_id' => 1,
        'event_name' => $name,
        'event_date' => $date,
        'event_start_time' => '20:00:00',
        'event_duration' => 90,
        'session_type' => 'Club',
        'event_price' => '65.00',
        'music_event_image' => '/images/test.webp',
        'venue_name' => 'Test Venue',
    ];
}

test('ticket view renders dynamic days before the all-round pass', function (): void {
    $html = renderDanceTickets(
        [
            [
                'date' => '2026-07-31',
                'weekday' => 'Friday',
                'formattedDate' => '31 July 2026',
                'dayPass' => ['pass_id' => 1, 'passName' => 'Friday Pass', 'passDescription' => 'Friday access', 'passPrice' => '79.00'],
                'tickets' => [sampleTicket('Friday Set', '2026-07-31')],
            ],
            [
                'date' => '2026-08-02',
                'weekday' => 'Sunday',
                'formattedDate' => '2 August 2026',
                'dayPass' => null,
                'tickets' => [sampleTicket('Sunday Set', '2026-08-02')],
            ],
        ],
        ['pass_id' => 9, 'passName' => 'All-Round Pass', 'passDescription' => 'Every current date', 'passPrice' => '199.00']
    );

    assertContainsText('Day 1', $html);
    assertContainsText('Friday 31 July 2026', $html);
    assertContainsText('Day 2', $html);
    assertContainsText('data-pass-id="1"', $html);
    assertContainsText('data-pass-id="9"', $html);

    if (strpos($html, 'All-Round Pass') < strpos($html, 'Sunday Set')) {
        throw new RuntimeException('All-round pass must render after every dated section');
    }
});

test('ticket view renders an empty message and can still show the all-round pass', function (): void {
    $html = renderDanceTickets(
        [],
        ['pass_id' => 9, 'passName' => 'All-Round Pass', 'passDescription' => 'Every current date', 'passPrice' => '199.00']
    );

    assertContainsText('No dance performances are currently available.', $html);
    assertContainsText('All-Round Pass', $html);
});
```

- [ ] **Step 2: Run the test and verify RED**

Run:

```powershell
php app/tests/run.php
```

Expected: FAIL because `app/views/frontend/dance/tickets.php` does not exist.

- [ ] **Step 3: Create the dynamic partial**

Create `app/views/frontend/dance/tickets.php` with local rendering closures:

```php
<?php
$renderPass = static function (array $pass): string {
    return '
    <div class="pass-container">
        <div class="top-section">
            <p class="pass-name">' . htmlspecialchars($pass['passName']) . '</p>
        </div>
        <div class="bottom-section">
            <div class="pass-details">
                <p class="pass-description">' . htmlspecialchars($pass['passDescription']) . '</p>
                <p class="pass-price">€' . htmlspecialchars($pass['passPrice']) . '</p>
            </div>
            <button class="buy-pass-button" data-pass-id="' . (int) $pass['pass_id'] . '">Add to cart</button>
        </div>
    </div>';
};

$renderTicket = static function (array $ticket): string {
    return '
    <div class="ticket-container">
        <div class="ticket">
            <div class="ticket-image">
                <img src="' . htmlspecialchars($ticket['music_event_image']) . '" alt="' . htmlspecialchars($ticket['event_name']) . '" />
            </div>
            <div class="ticket-details">
                <h2>' . htmlspecialchars($ticket['event_name']) . '</h2>
                <div class="ticket-info">
                    <p><strong>Location:</strong> ' . htmlspecialchars($ticket['venue_name']) . '</p>
                    <p><strong>Duration:</strong> ' . htmlspecialchars($ticket['event_duration']) . ' min</p>
                    <p><strong>Date &amp; Time:</strong> ' . htmlspecialchars($ticket['event_date']) . ' ' . htmlspecialchars($ticket['event_start_time']) . '</p>
                    <p><strong>Session:</strong> ' . htmlspecialchars($ticket['session_type']) . '</p>
                    <p><strong>Price:</strong> €' . htmlspecialchars($ticket['event_price']) . '</p>
                </div>
            </div>
            <input type="hidden" class="music-performance-id" value="' . (int) $ticket['music_performance_id'] . '" />
            <div class="ticket-buttons">
                <button class="buy-button">Add To Cart</button>
            </div>
        </div>
    </div>';
};
?>

<section class="dance-tickets" id="dance-tickets">
    <div class="dance-tickets__heading">
        <h2>Tickets</h2>
        <p>Choose a day pass or reserve a spot for an individual performance.</p>
    </div>

    <?php if (empty($danceDays)): ?>
        <p class="no-data">No dance performances are currently available.</p>
    <?php endif; ?>

    <?php foreach ($danceDays as $index => $day): ?>
        <div class="dance-day">
            <h3 class="ticket-list">
                Day <?= $index + 1 ?>
                <span><?= htmlspecialchars($day['weekday'] . ' ' . $day['formattedDate']) ?></span>
            </h3>

            <?php if ($day['dayPass'] !== null): ?>
                <div class="passes-container">
                    <?= $renderPass($day['dayPass']) ?>
                </div>
            <?php endif; ?>

            <div class="tickets-container">
                <?php foreach ($day['tickets'] as $ticket): ?>
                    <?= $renderTicket($ticket) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($allDatesPass !== null): ?>
        <div class="dance-day dance-all-dates">
            <h3 class="ticket-list">All Dates <span>Every current dance date</span></h3>
            <div class="passes-container">
                <?= $renderPass($allDatesPass) ?>
            </div>
        </div>
    <?php endif; ?>
</section>
```

- [ ] **Step 4: Replace the hardcoded blocks in the index view**

In `app/views/frontend/dance/index.php`, replace everything from the old `<!-- DAY 1 -->` comment through the closing tickets `</section>` with:

```php
<?php require __DIR__ . '/tickets.php'; ?>
```

Delete the old global `renderPass()` and `renderTicket()` functions because the partial now owns ticket-area rendering.

- [ ] **Step 5: Change pass AJAX to submit the ID**

Replace the pass click handler values in `app/views/frontend/dance/index.php`:

```javascript
const passId = $(this).data('pass-id');

$.ajax({
    url: '/dance/addpasstobasket',
    method: 'POST',
    data: { pass_id: passId },
```

Keep the existing success and error callbacks unchanged.

- [ ] **Step 6: Run tests and syntax checks**

Run:

```powershell
php app/tests/run.php
php -l app/views/frontend/dance/tickets.php
php -l app/views/frontend/dance/index.php
```

Expected: all tests PASS and both syntax checks report no errors.

- [ ] **Step 7: Commit**

```powershell
git add app/tests/DanceTicketsViewTest.php app/views/frontend/dance/tickets.php app/views/frontend/dance/index.php
git commit -m "feat: render dance tickets by performance date"
```

### Task 5: Purchase Passes By ID

**Files:**
- Modify: `app/tests/DanceServiceTest.php`
- Modify: `app/repositories/DanceRepository.php`
- Modify: `app/services/DanceService.php`
- Modify: `app/models/TicketPass.php`

- [ ] **Step 1: Add failing pass-by-ID tests**

Extend `FakeDancePageRepository` in `app/tests/DanceServiceTest.php`:

```php
public function getPassDetailsById(int $passId)
{
    if ($passId !== 5) {
        return false;
    }

    return [
        'pass_id' => 5,
        'passName' => 'Friday Pass',
        'passDescription' => 'Friday access',
        'passPrice' => 79,
        'passType' => 'Day Pass',
        'event_date' => '2026-07-31',
        'pass_scope' => 'day',
    ];
}
```

Add:

```php
test('creates a basket pass from pass ID', function (): void {
    $_POST = ['pass_id' => '5'];
    $service = new DanceService(new FakeDancePageRepository(), new DancePageDataBuilder());

    $pass = $service->createPass();
    $data = $pass->toArray();

    assertSameValue(5, $data['pass_id']);
    assertSameValue('day', $data['passScope']);
    assertSameValue('2026-07-31', $data['eventDate']);
});

test('rejects an unknown pass ID', function (): void {
    $_POST = ['pass_id' => '999'];
    $service = new DanceService(new FakeDancePageRepository(), new DancePageDataBuilder());

    try {
        $service->createPass();
        throw new RuntimeException('Expected unknown pass ID to fail');
    } catch (Exception $exception) {
        assertContainsText('Pass not found', $exception->getMessage());
    }
});
```

- [ ] **Step 2: Run the tests and verify RED**

Run:

```powershell
php app/tests/run.php
```

Expected: FAIL because `createPass()` still requires `pass_type` and the model does not expose the new metadata.

- [ ] **Step 3: Add repository lookup by primary key**

Replace `getPassDetailsByType()` in `app/repositories/DanceRepository.php` with:

```php
public function getPassDetailsById(int $passId)
{
    $stmt = $this->connection->prepare('
        SELECT pass_id, passName, passDescription, passPrice, passType, event_date, pass_scope
        FROM ticket_pass
        WHERE pass_id = :pass_id
    ');

    $stmt->bindParam(':pass_id', $passId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
```

- [ ] **Step 4: Update the ticket-pass model**

Add fields to `app/models/TicketPass.php`:

```php
private string $passScope;
private ?string $eventDate;
```

Extend the constructor after `$passType`:

```php
string $passScope,
?string $eventDate,
int $quantity
```

Assign both fields and add them to `toArray()` while retaining `passType`:

```php
return [
    'pass_id' => $this->pass_id,
    'passName' => $this->passName,
    'passDescription' => $this->passDescription,
    'passPrice' => $this->passPrice,
    'passType' => $this->passType,
    'passScope' => $this->passScope,
    'eventDate' => $this->eventDate,
    'quantity' => $this->quantity,
];
```

Add straightforward `getPassScope()` and `getEventDate()` getters. Existing basket, personal-program, and checkout code continues to detect dance passes through `passType`.

- [ ] **Step 5: Validate and load passes by ID in the service**

Replace `getPassDetailsByType()` with:

```php
public function getPassDetailsById(int $passId)
{
    try {
        return $this->danceRepository->getPassDetailsById($passId);
    } catch (Exception $e) {
        throw new Exception('Error: ' . $e->getMessage());
    }
}
```

Replace `createPass()` with:

```php
public function createPass()
{
    try {
        Validator::validate($_POST, ['pass_id' => 'required|numeric']);

        $passId = (int) $_POST['pass_id'];
        $passDetails = $this->getPassDetailsById($passId);

        if (!$passDetails) {
            throw new Exception('Pass not found');
        }

        return new TicketPass(
            (int) $passDetails['pass_id'],
            $passDetails['passName'],
            $passDetails['passDescription'],
            (int) $passDetails['passPrice'],
            $passDetails['passType'],
            $passDetails['pass_scope'],
            $passDetails['event_date'],
            1
        );
    } catch (Exception $e) {
        throw new Exception('Error: ' . $e->getMessage());
    }
}
```

- [ ] **Step 6: Remove obsolete weekday APIs**

Run:

```powershell
rg -n "getFridayEvents|getSaturdayEvents|getSundayEvents|getPassDetailsByType" app --glob "!vendor/**"
```

Expected: only declarations remain. Delete those declarations from `DanceService.php` and `DanceRepository.php`, then run the command again.

Expected after deletion: no matches.

- [ ] **Step 7: Run tests and syntax checks**

Run:

```powershell
php app/tests/run.php
php -l app/models/TicketPass.php
php -l app/services/DanceService.php
php -l app/repositories/DanceRepository.php
```

Expected: all tests PASS and all syntax checks report no errors.

- [ ] **Step 8: Commit**

```powershell
git add app/tests/DanceServiceTest.php app/models/TicketPass.php app/services/DanceService.php app/repositories/DanceRepository.php
git commit -m "feat: purchase dance passes by ID"
```

### Task 6: Full Verification

**Files:**
- Verify only; modify files only if a failing check reveals a defect.

- [ ] **Step 1: Run the complete automated suite**

Run:

```powershell
php app/tests/run.php
```

Expected: every test reports PASS and the process exits with code 0.

- [ ] **Step 2: Syntax-check every changed PHP file**

Run:

```powershell
$files = @(
  'app/services/DancePageDataBuilder.php',
  'app/repositories/DanceRepository.php',
  'app/services/DanceService.php',
  'app/controllers/HomeController.php',
  'app/models/TicketPass.php',
  'app/views/frontend/dance/index.php',
  'app/views/frontend/dance/tickets.php'
)
$files | ForEach-Object { php -l $_ }
```

Expected: every file reports `No syntax errors detected`.

- [ ] **Step 3: Check for stale hardcoding**

Run:

```powershell
rg -n "fridayTickets|saturdayTickets|sundayTickets|section-4a|section-4b|section-4c|data-passtype|pass_type" app --glob "!vendor/**"
```

Expected: no matches.

- [ ] **Step 4: Verify the live page**

With Docker running and the database updated, open:

```text
http://localhost/home/page?slug=dance&id=5
```

Verify:

- Date sections appear in chronological order.
- Multiple performances on the same date appear in one section.
- Each day pass appears only under its exact date.
- The all-round pass appears once after all date sections.
- Adding either kind of pass to the basket succeeds.

- [ ] **Step 5: Prove a new date needs no code change**

Create a temporary dance performance through the existing dance-management form using a new future date. Reload the dance page and verify a new sequential day section appears automatically. Delete the temporary performance afterward through the same management UI.

- [ ] **Step 6: Review the final diff**

Run:

```powershell
git diff --check
git status --short
git log -6 --oneline
```

Expected: no whitespace errors; only intended files are changed; the task commits are visible.
