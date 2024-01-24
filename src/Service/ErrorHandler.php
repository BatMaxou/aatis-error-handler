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

        $trace = $this->getTraceWithContext($file, $line, debug_backtrace());

        $this->render([
            'type' => 'Error',
            'code' => $level,
            'level' => $level,
            'file' => $file,
            'line' => $line,
            'message' => $message,
            'trace' => $trace,
        ]);

        exit;
    }

    public function handleException(\Throwable $exception): void
    {
        $this->logger->error(sprintf(self::LOG_PATERN, (string) $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine()));

        $trace = $this->getTraceWithContext($exception->getFile(), $exception->getLine(), $exception->getTrace());

        $class = $exception::class;
        $exploded = explode('\\', $class);

        $this->render([
            'type' => 'Exception',
            'class' => $class,
            'name' => end($exploded),
            'code' => (string) $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'previous' => $exception->getPrevious(),
            'trace' => $trace,
        ]);

        exit;
    }

    private function render(array $data = []): void
    {
        $dataTemplate = [
            'type' => null,
            'class' => null,
            'name' => null,
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

    private function getTraceWithContext(string $file, int $line, array $baseTrace): array
    {
        return array_map(
            fn ($step) => [...$step, 'context' => $this->getStepContext($step)],
            array_merge(
                [['file' => $file, 'line' => $line, 'isMain' => true]],
                $baseTrace
            )
        );
    }

    private function getStepContext(array $trace): array
    {
        $traceContext = [];
        $file = fopen($trace['file'], "r");
        $line_number = ($trace['line'] - 5 <= 0) ? 1 : $trace['line'] - 5;

        for ($i = 1; $i < $line_number; $i++) {
            fgets($file);
        }

        while ($line_number < $trace['line'] + 6 && !feof($file)) {
            $line = fgets($file);

            if ($line) {
                $traceContext[$line_number] = $line;
            }

            $line_number++;
        }

        fclose($file);

        return $traceContext;
    }
}
