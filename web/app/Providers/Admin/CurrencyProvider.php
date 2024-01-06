<?php

namespace App\Providers\Admin;


class CurrencyProvider {

    public $currency;

    public function __construct($currency = null)
    {
        $this->currency = $currency;
    }


    public function set($currency) {
        return $this->currency = $currency;
    }
    
    public function getData() {
        return $this->currency;
    }

    public static function default() {
        return app(CurrencyProvider::class)->getData();
    }
}