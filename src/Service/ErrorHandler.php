<?php

namespace Aatis\ErrorHandler\Service;

use Psr\Log\LoggerInterface;
use Aatis\ErrorHandler\Interface\ErrorHandlerInterface;

class ErrorHandler implements ErrorHandlerInterface
{
    private const LOG_PATERN = '[%s] %s - %s:%s';

    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public static function initialize(LoggerInterface $logger): void
    {
        $errorHandler = new self($logger);

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        set_error_handler([$errorHandler, 'handleError']);
        set_exception_handler([$errorHandler, 'handleException']);
    }

    public function handleError(int $level, string $message, string $file, int $line): bool
    {
        $this->logger->error(sprintf(self::LOG_PATERN, $level, $message, $file, $line));

        exit;
    }

    public function handleException(\Throwable $exception): void
    {
        $this->logger->error(sprintf(self::LOG_PATERN, (string) $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine()));

        exit;
    }
}
