<?php

namespace App\Controllers\Core;

use DateTime;

class Controller
{
    /**
     * Summary of run
     * @param callable $callback
     */
    protected function run(callable $callback)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            $this->handleException($e);
        }
    }

    /**
     * Summary of handleException
     * @param \Throwable $e
     * @param string $fallback
     * @return void
     */
    protected function handleException(\Throwable $e, string $fallback = '/')
    {
        if (defined('APP_DEBUG') && APP_DEBUG === true) {
            echo '<pre>';
            echo 'Message: ' . $e->getMessage() . PHP_EOL;
            echo 'File: ' . $e->getFile() . PHP_EOL;
            echo 'Line: ' . $e->getLine() . PHP_EOL;
            echo '</pre>';
            exit;
        }

        return $this->error('Something went wrong. Please try again.', $fallback);
    }

    /**
     * Summary of error
     * @param string $message
     * @param string $fallback
     * @return void
     */
    protected function error(string $message, string $fallback = '/')
    {
        $_SESSION['isError']       = 1;
        $_SESSION['flash_message'] = $message;

        $this->redirectBack($fallback);
    }

    /**
     * Summary of success
     * @param string $message
     * @param string $url
     * @return void
     */
    protected function success(string $message, string $url = '/')
    {
        $_SESSION['isError']       = 0;
        $_SESSION['flash_message'] = $message;

        $this->redirect($url);
    }

    /**
     * Summary of redirect
     * @param string $url
     * @return never
     */
    protected function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }

    /**
     * Summary of redirectBack
     * @param string $fallback
     * @return void
     */
    protected function redirectBack(string $fallback = '/')
    {
        $url = $_SERVER['HTTP_REFERER'] ?? $fallback;
        $this->redirect($url);
    }

    protected function getWeekDate(string $day): string
    {
        $date = new DateTime();

        // move to start of week (Monday)
        $date->modify('monday this week');

        return match ($day) {
            'friday'   => (clone $date)->modify('+4 days')->format('Y-m-d'),
            'saturday' => (clone $date)->modify('+5 days')->format('Y-m-d'),
            'sunday'   => (clone $date)->modify('+6 days')->format('Y-m-d'),
            default    => $date->format('Y-m-d'),
        };
    }
}
