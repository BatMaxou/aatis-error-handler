<?php

namespace Aatis\ErrorHandler\Service;

use Psr\Log\LoggerInterface;
use Aatis\ErrorHandler\Interface\ErrorHandlerInterface;

class ErrorHandler implements ErrorHandlerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public static function initialize(): void
    {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
    }

    public function handleError(int $level, string $message, string $file, int $line): void
    {
        echo "Error";
    }

    public function handleException(\Exception $exception): void
    {
        echo "Exception";
    }
}
