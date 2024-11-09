# Aatis Error Handler

## About

Aatis error handler displays errors and exceptions in a more user-friendly way. It also can log them if wanted.

## Installation

```bash
composer require aatis/error-handler
```

## Usage

### Initialization

To initialize the error handler, pass the following parameters to the static `initialize()` method:

- an instance of `ErrorCodeBag` service of this package
- an instance of `ExceptionCodeBag` service of this package
- a logger service that implements the `Psr\Log\LoggerInterface`

```php
ErrorHandler::initialize(
    new ErrorCodeBag(),
    new ExceptionCodeBag(),
    new Logger(),
);
```

> [!NOTE]
> The logger service is optional. If you do not provide it, the error handler will not log any message.

> [!NOTE]
> If needed, Aatis provides a Loger that implements the `Psr\Log\LoggerInterface`.
> See `aatis/logger` (https://github.com/BatMaxou/aatis-logger).

### ErrorCodeBag

`ErrorCodeBag` service store 15 error codes corresponding to the 15 error levels of PHP error:

- 1 => 'E_ERROR'
- 2 => 'E_WARNING'
- 4 => 'E_PARSE'
- 8 => 'E_NOTICE'
- 16 => 'E_CORE_ERROR'
- 32 => 'E_CORE_WARNING'
- 64 => 'E_COMPILE_ERROR'
- 128 => 'E_COMPILE_WARNING'
- 256 => 'E_USER_ERROR'
- 512 => 'E_USER_WARNING'
- 1024 => 'E_USER_NOTICE'
- 2048 => 'E_STRICT'
- 4096 => 'E_RECOVERABLE_ERROR'
- 8192 => 'E_DEPRECATED'
- 16384 => 'E_USER_DEPRECATED'

> [!WARNING]
> It is not possible to override any error codes from this bag.

### ExceptionCodeBag

`ExceptionCodeBag` service store any exception code you want to use in your application. By default, a list with all the 400 and 500 exception codes is provided, but it can be extanded and/or overrided:

- 0 => 'Basic Error'
- 400 => 'Bad Request'
- 401 => 'Unauthorized'
- 402 => 'Payment Required Experimental'
- 403 => 'Forbidden'
- 404 => 'Not Found'
- 405 => 'Method Not Allowed'
- 406 => 'Not Acceptable'
- 407 => 'Proxy Authentication Required'
- 408 => 'Request Timeout'
- 409 => 'Conflict'
- 410 => 'Gone'
- 411 => 'Length Required'
- 412 => 'Precondition Failed'
- 413 => 'Payload Too Large'
- 414 => 'URI Too Long'
- 415 => 'Unsupported Media Type'
- 416 => 'Range Not Satisfiable'
- 417 => 'Expectation Failed'
- 418 => 'I\'m a teapot'
- 421 => 'Misdirected Request'
- 422 => 'Unprocessable Content'
- 423 => 'Locked'
- 424 => 'Failed Dependency'
- 425 => 'Too Early Experimental'
- 426 => 'Upgrade Required'
- 428 => 'Precondition Required'
- 429 => 'Too Many Requests'
- 431 => 'Request Header Fields Too Large'
- 451 => 'Unavailable For Legal Reasons'
- 500 => 'Internal Server Error'
- 501 => 'Not Implemented'
- 502 => 'Bad Gateway'
- 503 => 'Service Unavailable'
- 504 => 'Gateway Timeout'
- 505 => 'HTTP Version Not Supported'
- 506 => 'Variant Also Negotiates'
- 507 => 'Insufficient Storage'
- 508 => 'Loop Detected'
- 510 => 'Not Extended'
- 511 => 'Network Authentication Required'

### Custom Exception Code

You can add or override any exception codes by creating a custom string enum like the following template:

```php
enum ExampleExceptionCodeEnum: string
{
    case _404 = 'Custom Not Found';
    case _30 = 'Custom Error 30';
}
```

Then, pass it into the `ExceptionCodeBag` service constructor.

```php
new ExceptionCodeBag([
    ExampleExceptionCodeEnum::class,
    OtherExampleExceptionCodeEnum::class
]);
```

> [!NOTE]
> You can pass as many enums as you want.

To precise a specific code to an exception, follow this example:

```php
throw new \Exception('My custom message', 30);
```

## With Aatis Framework

### Requirements

Add `ErrorCodeBag` and `ExceptionCodeBag` services to the `Container`:

```yaml
# In config/services.yaml file :

include_services:
  - 'Aatis\ErrorHandler\Service\ErrorCodeBag'
  - 'Aatis\ErrorHandler\Service\ExceptionCodeBag'
```

### ExceptionCodeBag

If you want to add or override any exception codes from the `ExceptionCodeBag`,
do not forget to precise your custom enums to the `ExceptionCodeBag` service:

```yaml
# In config/services.yaml file :

services:
  Aatis\ErrorHandler\Service\ExceptionCodeBag:
    arguments:
      extraExceptionCodeEnums:
        - 'Namespace\To\ExampleExceptionCodeEnum'
        - 'Namespace\To\OtherExampleExceptionCodeEnum'
```
