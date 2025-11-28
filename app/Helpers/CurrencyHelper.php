<?php

if (!function_exists('formatCurrency')) {
    /**
     * Format amount with currency symbol
     */
    function formatCurrency($amount, $currency = 'INR')
    {
        $symbols = [
            'INR' => '₹',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
        ];

        $symbol = $symbols[$currency] ?? '₹';
        $formatted = number_format((float) $amount, 2, '.', ',');

        return $symbol . $formatted;
    }
}

if (!function_exists('getCurrencySymbol')) {
    /**
     * Get currency symbol
     */
    function getCurrencySymbol($currency = 'INR')
    {
        $symbols = [
            'INR' => '₹',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
        ];

        return $symbols[$currency] ?? '₹';
    }
}

