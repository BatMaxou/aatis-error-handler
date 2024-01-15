<?php

namespace Aatis\ErrorHandler\Interface;

interface ErrorHandlerInterface
{
    public static function initialize(): void;

    public function handleError(int $level, string $message, string $file, int $line): void;

    public function handleException(\Exception $exception): void;
}
