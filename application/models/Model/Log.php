<?php
namespace App\Models\Model;


class Log extends QueryBuilder
{
    private static $accessFile = '../application/Models/etc/access.log';
    private static $errorFile = '../application/Models/etc/error.log';

    public static function access()
    {
        $log = file_get_contents(self::$accessFile);

        empty($log) ? file_put_contents(self::$accessFile, $log . "[" . date('d-m-Y h:i:s', time()) . "] " . self::$query) : file_put_contents(self::$accessFile, $log . "\n[" . date('d-m-Y h:i:s', time()) . "] " . self::$query);
    }

    public static function error()
    {
        $message = self::$prepare->errorInfo();
        var_dump($message);
        error_log("[" . date('d-m-Y h:i:s', time()) . "] " . self::$queryType . " : " . $message[2] . "\n", 3, self::$errorFile);
    }
}