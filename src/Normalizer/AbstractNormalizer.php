<?php

namespace App\Normalizer;

abstract class AbstractNormalizer implements INormalizer
{
    public function support(\Throwable $exception): bool
    {
        $exceptionSupported = $this->getExceptionSupported();

        return $exception instanceof $exceptionSupported;
    }
}