<?php
/**
 * Created by PhpStorm.
 * User: jzplius
 * Date: 11/29/15
 * Time: 12:20 PM
 */

namespace AppBundle;


use DateTime;

/**
 * Various static methods being used in whole Bundle scope.
 * @package AppBundle
 */
class Utilities
{
    public static $STATUS_JOINING_TIME_IS_OVER = "Joining time is over!";

    /**
     * Compares passed datetime with now and returns amount of time remaining till event.
     * Returns as little as possible data, f.e. "15 minutes", instead of "0 days 0 hours 15 minutes".
     * @param $timestamp
     * @return string amount of time remaining from now
     */
    public static function countTimeRemaining($timestamp) {
        $now = new DateTime();
        $future_date = new DateTime();
        $future_date->setTimestamp($timestamp);

        $interval = $now->diff($future_date);

        // FIXME: would be useful to show correct plural state (f.e. hour / hours)
        if ($interval->invert) {
            return Utilities::$STATUS_JOINING_TIME_IS_OVER;
        } else if ($interval->d > 0) {
            return $interval->format("%a day(s), %h hour(s)");
        } else if ($interval->h > 0) {
            return $interval->format("%h hour(s), %i minute(s)");
        } else if ($interval->i > 0) {
            return $interval->format("%i minute(s)");
        }
    }
}