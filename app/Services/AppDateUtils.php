<?php

namespace App\Services;

use App\Models\AnnualReturnScheduleRecord;
use Carbon\Carbon;
use Throwable;

final class AppDateUtils {
    
    public static function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }

    public static function monthNames() {
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',

            // for the sake of case sensitivity in validation
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july ',
            'august',
            'september',
            'october',
            'november',
            'december',
        ];
        
        return $months;
    }

    public static function getDateYearEnd($dateStr) {
        try {
           return new Carbon('last day of December ' . $dateStr);
        } catch(Throwable $e) {

        }

        return null;
    }

    public static function getDateYmdFromDate($date) {
        return Carbon::parse($date)->endOfYear()->format('Y-m-d');
    }

    public static function getDateYmdFromString($dateStr) {

        try {
            // put date to format ok for comparison
            $carbonDate = new Carbon('last day of December ' . $dateStr);
            
            return Carbon::parse($carbonDate)->endOfYear()->format('Y-m-d');
        } catch(Throwable $e) {

        }

        return null;

    }
}                             