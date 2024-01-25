<?php

namespace Aatis\ErrorHandler\Service;

use Aatis\ErrorHandler\Enum\ClientExceptionCodeEnum;
use Aatis\ErrorHandler\Enum\ServerExceptionCodeEnum;

class ExceptionCodeBag extends AbstractCodeBag
{
    public function __construct(private readonly array $extraExceptionCodeEnums = [])
    {
        $this->setCodeEnums([ClientExceptionCodeEnum::class, ServerExceptionCodeEnum::class]);
        parent::__construct($extraExceptionCodeEnums);
    }
}
