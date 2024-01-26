<?php

namespace Aatis\ErrorHandler\Service;

use Aatis\ErrorHandler\Enum\ClientExceptionCodeEnum;
use Aatis\ErrorHandler\Enum\ServerExceptionCodeEnum;

class ExceptionCodeBag extends AbstractCodeBag
{
    /**
     * @param array<class-string> $extraExceptionCodeEnums
     */
    public function __construct(array $extraExceptionCodeEnums = [])
    {
        $this->setCodeEnums([ClientExceptionCodeEnum::class, ServerExceptionCodeEnum::class]);
        parent::__construct($extraExceptionCodeEnums);
    }
}
