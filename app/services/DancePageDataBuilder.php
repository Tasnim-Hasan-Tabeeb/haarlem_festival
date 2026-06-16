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
