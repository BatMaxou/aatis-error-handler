<?php

namespace Aatis\ErrorHandler\Interface;

use Aatis\ErrorHandler\Service\ErrorCodeBag;
use Aatis\ErrorHandler\Service\ExceptionCodeBag;
use Psr\Log\LoggerInterface;

interface ErrorHandlerInterface
{
    public static function initialize(LoggerInterface $loggerInterface, ErrorCodeBag $errorCodeBag, ExceptionCodeBag $exceptionCodeBag): ErrorHandlerInterface;

    public function handleError(int $level, string $message, string $file, int $line): bool;

    public function handleException(\Throwable $exception): void;
}
