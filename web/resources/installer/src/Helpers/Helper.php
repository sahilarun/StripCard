<?php

namespace Project\Installer\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Project\Installer\Helpers\URLHelper;

class Helper {

    public $cache_key = "installer_cache";

    public function cache(array $data = []) {
        if(count($data) == 0) {
            return cache()->driver('file')->get($this->cache_key);
        }
        if(cache()->driver('file')->get($this->cache_key)) {
            $cache = cache()->driver('file')->get($this->cache_key);
            $data = array_merge($cache,$data);
            cache()->driver('file')->put($this->cache_key,$data,111600);
        }else {
            cache()->driver('file')->put($this->cache_key,$data,111600);
        }
    }

    public function client() {
        $url = new URLHelper();
        return [
            'client'   => $url->base_get(),
        ];
    }

    public function connection(array $data) {
        $url = new URLHelper();
        $connection_response = Http::acceptJson()->post($url->getConnection(),$data);
        if($connection_response->failed()) {
            $message = $connection_response->collect()->get('data')['message'] ?? "";
            throw new Exception($message);
        }
    }

    public function signature(string|array $data) {
        if(is_string($data)) return base64_encode($data);
        $data = json_encode($data);
        return base64_encode($data);
    }

    public function generateAppKey() {
        return Artisan::call("key:generate");
    }

}
