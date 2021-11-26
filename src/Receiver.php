<?php
namespace Tyz\Debug;
class Receiver {
    public static $host = "192.168.8.165";
    public static $port = 8989;
    public static $seperator = "###\n";

    public static function resetConn($host, $port) {
        $host && static::$host = $host;
        if ($port && $port > 2000) {
            static::$port = intval($port);
        }
    }

    public static function resetSeperator($seperator) {
        $seperator && static::$seperator = $seperator;
    }
}