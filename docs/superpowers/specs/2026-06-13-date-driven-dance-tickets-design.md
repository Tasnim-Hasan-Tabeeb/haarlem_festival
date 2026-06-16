# Date-Driven Dance Tickets Design

## Goal

Render dance tickets and passes from database dates so adding a dance performance on a new date does not require frontend or controller changes.

## Database

Add these columns to `ticket_pass`:

- `event_date DATE NULL`
- `pass_scope ENUM('day', 'all_dates') NOT NULL`

The data rules are:

- A `day` pass must have an `event_date`.
- An `all_dates` pass must have `event_date = NULL`.
- There is one all-round pass.
- A date may have at most one day pass.

Update the SQL seed data as follows:

- Saturday pass: `pass_scope = 'day'`, `event_date = '2026-06-27'`
- Friday pass: `pass_scope = 'day'`, `event_date = '2026-07-31'`
- Sunday pass: `pass_scope = 'day'`, `event_date = '2026-08-02'`
- Weekend/all-round pass: `pass_scope = 'all_dates'`, `event_date = NULL`

The all-round pass dynamically covers every date represented by the current dance performances. It does not store a copied list of dates.

## Data Flow

The dance repository will return active performances ordered by `music_events.event_date` and start time. It will also return passes with their scope and optional date.

The service will build page data with:

- `danceDays`: chronologically ordered groups containing a date, display labels, matching day pass, and performances.
- `allDatesPass`: the single pass whose scope is `all_dates`, or `null` if none exists.

Only dates that have at least one dance performance produce a day section. A date section still renders its performance tickets if no matching day pass exists.

The existing Friday, Saturday, and Sunday repository/service methods will be removed from the page flow. The broken `getEventsByDate()` query will be corrected if retained, but the page should use one ordered query rather than one query per date.

## Frontend

Replace the three hardcoded day blocks with a loop over `danceDays`.

Each section displays:

- Sequential label: `Day 1`, `Day 2`, and so on.
- Formatted weekday and calendar date.
- The day pass whose `event_date` equals the section date.
- All performance tickets on that date.

After every date section, render the all-round pass once in a clearly labelled all-dates section. If no all-round pass exists, omit that section.

The existing ticket and pass card styling and cart feedback remain unchanged.

## Pass Purchase

Pass purchase buttons will submit `pass_id` instead of `passType`.

The service validates that `pass_id` is present and numeric. The repository loads the pass by its primary key. This avoids ambiguity because every day pass has the same `day` scope.

The basket item continues to store the pass name, description, price, scope, and quantity. The scope replaces the previous use of a descriptive pass type as an identifier.

## Error Handling

- Missing or invalid `pass_id`: return the existing HTTP 400 JSON error response.
- Unknown pass ID: return `Pass not found`.
- No performances: render the tickets heading with a no-events message, followed by the all-round pass if configured.
- Missing day pass for a performance date: render the performances without a pass card.

## Testing

Add focused automated coverage for the page-data grouping behavior:

- Performance dates are sorted chronologically.
- Multiple performances on one date produce one section.
- A newly added date automatically produces another section.
- Day passes match only their exact date.
- The all-round pass is separate from date groups.

Add service coverage for pass lookup by `pass_id`, including an unknown ID. Verify the rendered page contains dynamic day sections in chronological order and renders the all-round pass after them.

## Scope

This change does not add support for passes covering arbitrary subsets of dates, redesign the dance page, or change performance management beyond making newly entered dates appear automatically.
