<?php

namespace Aatis\ErrorHandler\Service;

use Aatis\ErrorHandler\Interface\CodeBagInterface;

abstract class AbstractCodeBag implements CodeBagInterface
{
    private array $codeEnums = [];

    public function __construct(private readonly array $extraCodeEnums = [])
    {
        if (!empty($extraCodeEnums)) {
            $this->registerExtraCodeEnums();
        }
    }

    public function getCodeDescription(int $code): string
    {
        $description = 'Unknown Error Code';

        foreach ($this->codeEnums as $exceptionCodeEnum) {
            foreach ($exceptionCodeEnum::cases() as $case) {
                if ('_' . $code === $case->name) {
                    $description = $case->value;
                }
            }
        }

        return $description;
    }

    protected function setCodeEnums(array $codeEnums): self
    {
        $this->codeEnums = $codeEnums;

        return $this;
    }

    private function registerExtraCodeEnums(): void
    {
        foreach ($this->extraCodeEnums as $extraCodeEnum) {
            if (enum_exists($extraCodeEnum)) {
                $this->codeEnums[] = $extraCodeEnum;
            }
        }
    }
}
