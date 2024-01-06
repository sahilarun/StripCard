<?php

namespace App\Providers\Admin;


class BasicSettingsProvider {

    public $setting;

    public function __construct($settings = null)
    {
        $this->setting = $settings;
    }


    public function set($settings) {
        return $this->setting = $settings;
    }
    
    public function getData() {
        return $this->setting;
    }

    public static function get() {
        return app(BasicSettingsProvider::class)->getData();
    }
}