<?php

namespace App\Services\Api\V1\DocumentReader;

use PhpOffice\PhpSpreadsheet\IOFactory;

interface DocumentInterface
{
    public function readFile(...$options): array;

    public function parser(string $inputFileName, ...$options);
}
