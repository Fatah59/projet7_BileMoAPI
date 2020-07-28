<?php

namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;

interface INormalizer
{
    public function normalize(\Throwable $exception): Response;

    public function support(\Throwable $exception): bool;

    public function getExceptionSupported(): string;
}