<?php
class DateTimeHelper {

    public static function toHuman($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->diffForHumans();
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->diffForHumans();

    }


    public static function toShortDate($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->toFormattedDateString();
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->toFormattedDateString();

    }

    public static function toLongDate($datetime, $timezone = null){

        if(!is_null($timezone)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                ->setTimezone($timezone)
                ->format('F j, Y');
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $datetime, Config::get('app.timezone'))
                        ->format('F j, Y');

    }

}