<?php

namespace Aatis\ErrorHandler\Enum;

enum ServerExceptionCodeEnum: string
{
    case _500 = "Internal Server Error";
    case _501 = "Not Implemented";
    case _502 = "Bad Gateway";
    case _503 = "Service Unavailable";
    case _504 = "Gateway Timeout";
    case _505 = "HTTP Version Not Supported";
    case _506 = "Variant Also Negotiates";
    case _507 = "Insufficient Storage";
    case _508 = "Loop Detected";
    case _510 = "Not Extended";
    case _511 = "Network Authentication Required";
}
