<?php

namespace Aatis\ErrorHandler\Interface;

use Psr\Log\LoggerInterface;

interface ErrorHandlerInterface
{
    public static function initialize(LoggerInterface $loggerInterface): void;

    public function handleError(int $level, string $message, string $file, int $line): bool;

    public function handleException(\Exception $exception): void;
}
