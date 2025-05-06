<?php


namespace TreviPay\TreviPayMagento\Model;

use Magento\Framework\Locale\CurrencyInterface;
use TreviPay\TreviPayMagento\Model\CurrencyInterface as TreviPayMagentoCurrencyInterface;
use Magento\Framework\Currency\Exception\CurrencyException;

class PriceFormatter
{
    /**
     * @var CurrencyInterface
     */
    private $localeCurrency;

    public function __construct(
        CurrencyInterface $localeCurrency
    ) {
        $this->localeCurrency = $localeCurrency;
    }

    /**
     * @param float $price
     * @param string|null $currency
     * @return string
     * @throws CurrencyException
     */
    public function getPriceFormatted(float $price, ?string $currency, $appendCurrency = true): string
    {
        $localeCurrency = $this->localeCurrency->getCurrency($currency);
        $options = ['precision' => $this->getNumberOfDecimalPlaces($currency), 'symbol' => ''];

        return $localeCurrency->toCurrency($price, $options) . ($appendCurrency ? ' '.$currency : '');
    }

    /**
     * Convert price from cents to dollar amount in the currency's format
     *
     * @param integer $price
     * @param string|null $currency
     * @return string
     * @throws CurrencyException
     */
    public function getPriceFormattedFromCents(int $price, ?string $currency, $appendCurrency = true): string
    {
        $precision = $this->getNumberOfDecimalPlaces($currency);
        $price = $price / pow(10, $precision);
        return $this->getPriceFormatted($price, $currency, $appendCurrency);
    }

    /**
     * @param float $price
     * @param string|null $currency
     * @return string
     */
    public function getPriceFormattedInEasyToCopyFormat(float $price, ?string $currency): string
    {
        return number_format($price, $this->getNumberOfDecimalPlaces($currency), '.', '');
    }

    private function getNumberOfDecimalPlaces(?string $currency): int
    {
        $numberOfDecimalPlaces = 2;
        if (in_array($currency, TreviPayMagentoCurrencyInterface::CURRENCIES_WITH_THREE_DECIMAL_PLACES)) {
            $numberOfDecimalPlaces = 3;
        } elseif (in_array($currency, TreviPayMagentoCurrencyInterface::CURRENCIES_WITH_ZERO_DECIMAL_PLACES)) {
            $numberOfDecimalPlaces = 0;
        }

        return $numberOfDecimalPlaces;
    }
}
