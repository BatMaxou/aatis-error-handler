<?php

namespace Aatis\ErrorHandler\Enum;

enum ErrorCodeEnum: string
{
    case _1 = 'E_ERROR';
    case _2 = 'E_WARNING';
    case _4 = 'E_PARSE';
    case _8 = 'E_NOTICE';
    case _16 = 'E_CORE_ERROR';
    case _32 = 'E_CORE_WARNING';
    case _64 = 'E_COMPILE_ERROR';
    case _128 = 'E_COMPILE_WARNING';
    case _256 = 'E_USER_ERROR';
    case _512 = 'E_USER_WARNING';
    case _1024 = 'E_USER_NOTICE';
    case _2048 = 'E_STRICT';
    case _4096 = 'E_RECOVERABLE_ERROR';
    case _8192 = 'E_DEPRECATED';
    case _16384 = 'E_USER_DEPRECATED';
}
