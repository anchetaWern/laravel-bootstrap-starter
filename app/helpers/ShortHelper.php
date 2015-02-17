<?php
class ShortHelper {

    public static function time($time_string){

        $words = explode(" ", $time_string);
        array_pop($words);
        $short = "";
        foreach($words as $w){
          $short .= $w[0];
        }
        return $short;

    }
}