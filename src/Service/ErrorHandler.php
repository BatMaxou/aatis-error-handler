<?php

namespace Aatis\ErrorHandler\Service;

use Psr\Log\LoggerInterface;
use Aatis\ErrorHandler\Interface\ErrorHandlerInterface;

class ErrorHandler implements ErrorHandlerInterface
{
    private const LOG_PATERN = '[%s] %s - %s:%s';

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ErrorCodeBag $errorCodeBag,
        private readonly ExceptionCodeBag $exceptionCodeBag,
    ) {
    }

    public static function initialize(LoggerInterface $logger, ErrorCodeBag $errorCodeBag, ExceptionCodeBag $exceptionCodeBag): self
    {
        $errorHandler = new self($logger, $errorCodeBag, $exceptionCodeBag);

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        set_error_handler([$errorHandler, 'handleError']);
        set_exception_handler([$errorHandler, 'handleException']);

        return $errorHandler;
    }

    public function handleError(int $level, string $message, string $file, int $line): bool
    {
        $this->logger->error(sprintf(self::LOG_PATERN, $level, $message, $file, $line));

        $trace = $this->getTraceWithContext($file, $line, debug_backtrace(), true);

        $trace = $this->replaceSpaceByTab($trace);

        $this->render([
            'type' => 'Error',
            'level' => $level,
            'description' => $this->errorCodeBag->getCodeDescription($level),
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

        $trace = $this->replaceSpaceByTab($trace);

        $this->render([
            'type' => 'Exception',
            'class' => $class,
            'name' => end($exploded),
            'code' => (string) $exception->getCode(),
            'description' => $this->exceptionCodeBag->getCodeDescription($exception->getCode()),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'trace' => $trace,
        ]);

        exit;
    }

    /**
     * @param mixed[] $data
     */
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

        require_once __DIR__.'/../../templates/error.tpl.php';
    }

    /**
     * @param array<array{
     *  file?: string,
     *  line?: int,
     * }> $baseTrace
     *
     * @return array<array{
     *  file?: string,
     *  line?: int,
     *  context: array<int, string>,
     * }>
     */
    private function getTraceWithContext(string $file, int $line, array $baseTrace, bool $isError = false): array
    {
        return array_filter(
            array_map(
                fn ($step) => [...$step, 'context' => $this->getStepContext($step)],
                $isError ? $baseTrace : array_merge(
                    [['file' => $file, 'line' => $line]],
                    $baseTrace
                )
            ),
            fn ($step) => null !== $step['context']
        );
    }

    /**
     * @param array{
     *  file?: string,
     *  line?: int,
     * } $trace
     *
     * @return array<int, string>|null
     */
    private function getStepContext(array $trace): ?array
    {
        if (!isset($trace['file']) || !isset($trace['line'])) {
            return null;
        }

        $traceContext = [];
        $file = fopen($trace['file'], 'r');

        if (!$file) {
            return null;
        }

        $line_number = ($trace['line'] - 5 <= 0) ? 1 : $trace['line'] - 5;

        for ($i = 1; $i < $line_number; ++$i) {
            fgets($file);
        }

        while ($line_number < $trace['line'] + 6 && !feof($file)) {
            $line = fgets($file);

            if ($line) {
                $traceContext[$line_number] = $line;
            }

            ++$line_number;
        }

        fclose($file);

        return $traceContext;
    }

    /**
     * @param array<array{
     *  file?: string,
     *  line?: int,
     *  context: array<int, string>,
     * }> $trace
     *
     * @return array<array{
     *  file?: string,
     *  line?: int,
     *  context: array<int, string>,
     * }>
     */
    private function replaceSpaceByTab(array $trace): array
    {
        return array_map(
            function ($step) {
                $step['context'] = array_map(
                    fn ($line) => str_replace('    ', '&nbsp&nbsp&nbsp&nbsp', $line),
                    $step['context']
                );

                return $step;
            },
            $trace
        );
    }
}
