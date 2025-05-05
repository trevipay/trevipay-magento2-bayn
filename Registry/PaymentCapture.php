<?php
declare(strict_types=1);

namespace TreviPay\TreviPayMagento\Registry;

class PaymentCapture
{
    /**
     * @var bool
     */
    private $isSkipped = false;

    public function skip(): void
    {
        $this->isSkipped = true;
    }

    public function isSkipped(): bool
    {
        return $this->isSkipped;
    }
}
