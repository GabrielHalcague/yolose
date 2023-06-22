<?php

class Logger
{
    public static function info($log)
    {
        self::log('INFO', $log, "\033[0;32m"); // Green color
    }

    public static function warning($log)
    {
        self::log('WARN', $log, "\033[0;33m"); // Yellow color
    }

    public static function error($log)
    {
        self::log('ERROR', $log, "\033[0;31m"); // Red color
    }

    private static function log($level, $log, $color)
    {
        $message = self::createMessage($level, $log, $color);
        self::writeLogFile($message);
        echo $message; // También imprimimos el mensaje en la salida estándar
    }

    private static function createMessage($level, $log, $color): string
    {
        return "[" . self::getDate() . "][" . $color . $level . "\033[0m] " . $log . "\n";
    }

    private static function writeLogFile(string $message): void
    {
        $filename = "log/log-" . self::getDate() . ".txt";
        file_put_contents($filename, $message, FILE_APPEND);
    }

    private static function getDate()
    {
        return date("Y-m-d");
    }
}