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

        $this->render([
            'title' => 'Error',
            'code' => $level,
            'level' => $level,
            'file' => $file,
            'line' => $line,
            'message' => $message,
            'trace' => debug_backtrace(),
        ]);

        exit;
    }

    public function handleException(\Throwable $exception): void
    {
        $this->logger->error(sprintf(self::LOG_PATERN, (string) $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine()));

        $this->render([
            'title' => 'Exception',
            'code' => (string) $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'previous' => $exception->getPrevious(),
            'trace' => $exception->getTrace(),
        ]);

        exit;
    }

    private function render(array $data = []): void
    {
        $dataTemplate = [
            'title' => 'Notice',
            'code' => null,
            'level' => null,
            'file' => null,
            'line' => null,
            'message' => null,
            'previous' => null,
            'trace' => null,
        ];

        extract($dataTemplate);
        extract($data);

        require_once __DIR__ . '/../../templates/error.tpl.php';
    }
}
