<?php

namespace Aatis\ErrorHandler\Interface;

interface CodeBagInterface
{
    public function getCodeDescription(int $code): string;
}
