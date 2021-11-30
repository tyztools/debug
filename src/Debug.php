<?php
namespace Tyz\Debug;
use Swoole\Client;
class Debug
{
    public static function echo ($str, $project = "") {
        $debugRes = debug_backtrace();
        $info     = array(
            "uuid"     => Identity::getUuid($project),
            "data"     => $str,
            "line"     => isset($debugRes[0]["line"]) ?  $debugRes[0]["line"] : 0,
            "filepath" => isset($debugRes[0]["file"]) ? $debugRes[0]["file"] : "",
        );
        static::dispatch($info);
    }

    public static function var_dump($arr, $project="") {
        $debugRes = debug_backtrace();
        if (!is_array($arr)) {
            $arr = array($arr);
        }
        $info     = array(
            "uuid"     => Identity::getUuid($project),
            "data"     => var_export($arr, true),
            "line"     => isset($debugRes[0]["line"]) ?  $debugRes[0]["line"] : 0,
            "filepath" => isset($debugRes[0]["file"]) ? $debugRes[0]["file"] : "",
        );
        static::dispatch($info);
    }

    public static function dispatch($data)
    {
        if (!extension_loaded("swoole")) {
            return;
        }
        $client = new Client(SWOOLE_SOCK_TCP);
        if (!$client->connect(Receiver::$host, Receiver::$port, -1)) {
            return;
        }
        $client->send(json_encode($data, JSON_UNESCAPED_UNICODE).Receiver::$seperator);
        $client->close();
    }

}
