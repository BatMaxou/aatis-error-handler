<?php

namespace Aatis\ErrorHandler\Service;

use Aatis\ErrorHandler\Enum\ErrorCodeEnum;

class ErrorCodeBag extends AbstractCodeBag
{
    public function __construct()
    {
        $this->setCodeEnums([ErrorCodeEnum::class]);
        parent::__construct();
    }
}
