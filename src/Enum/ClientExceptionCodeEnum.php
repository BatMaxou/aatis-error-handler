<?php

namespace Aatis\ErrorHandler\Enum;

enum ClientExceptionCodeEnum: string
{
    case _0 = "Basic Error";
    case _400 = "Bad Request";
    case _401 = "Unauthorized";
    case _402 = "Payment Required Experimental";
    case _403 = "Forbidden";
    case _404 = "Not Found";
    case _405 = "Method Not Allowed";
    case _406 = "Not Acceptable";
    case _407 = "Proxy Authentication Required";
    case _408 = "Request Timeout";
    case _409 = "Conflict";
    case _410 = "Gone";
    case _411 = "Length Required";
    case _412 = "Precondition Failed";
    case _413 = "Payload Too Large";
    case _414 = "URI Too Long";
    case _415 = "Unsupported Media Type";
    case _416 = "Range Not Satisfiable";
    case _417 = "Expectation Failed";
    case _418 = "I'm a teapot";
    case _421 = "Misdirected Request";
    case _422 = "Unprocessable Content";
    case _423 = "Locked";
    case _424 = "Failed Dependency";
    case _425 = "Too Early Experimental";
    case _426 = "Upgrade Required";
    case _428 = "Precondition Required";
    case _429 = "Too Many Requests";
    case _431 = "Request Header Fields Too Large";
    case _451 = "Unavailable For Legal Reasons";
}
