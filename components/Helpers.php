<?php
namespace app\components;

class Helpers
{
    public static function digits($var = 0)
    {
        return number_format($var, 2, ",", ".");
    }

    public static function dateFormat($date = '0000-00-00')
    {
        if ($date != '0000-00-00') {
            return date('d F Y', strtotime($date));
        }
        return '-';
    }

    public static function dateTimeFormat($date_time = '0000-00-00 00:00:00')
    {
        if ($date_time != '0000-00-00 00:00:00') {
            return date('d F Y H:i', strtotime($date_time));
        }
        return '-';
    }

    public static function createApiKey($community_name = 'smartcom')
    {
        $salt = 'Sm4RtComSPE101!?';
        $time = date("ymdhis");
        $uniqid = uniqid();
        $rand = mt_rand(0, 100);

        $prefix = substr($community_name, 0, 3);

        return $prefix . md5(sha1($salt . $time . $uniqid . $rand));
    }

    public static function generateSK()
    {
        if (time() % 2 == 1)
            return uniqid() . mt_rand(100, 900);
        else
            return mt_rand(100, 900) . uniqid();
    }

    //for ppob response tag
    public static function viewResponseTag($str = '')
    {
        if (!$str or $str == '') return '-';
        $s = '<?xml version="1.0" encoding="UTF-8"?><xml>';
        $s .= $str;
        $s .= '</xml>';

        $element = new \SimpleXMLElement($s);
        //dd((array)$element);
        $new = json_encode($element);
        //
        $arr = json_decode($new, true);
        return $arr;
    }

    public static function printResponseTag($str = '')
    {
        if (!$str or $str == '') return '-';
        return htmlentities($str);
    }
}