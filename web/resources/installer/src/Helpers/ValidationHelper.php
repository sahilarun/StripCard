<?php 

namespace Project\Installer\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use Project\Installer\Helpers\Helper;
use Project\Installer\Helpers\URLHelper;

class ValidationHelper {

    public function validate(array $data) {

        $config = new ConfigHelper();
        $url = new URLHelper();
        $db = new DBHelper();
        $helper = new Helper();

        $data['client'] = $helper->client();
        $helper->connection($data);

        $helper->cache($data);

        $this->setStepSession();
    }

    public function setStepSession() {
        session()->put('validation',"PASSED");
    }

    public static function step() {
        return session('validation');
    }
}