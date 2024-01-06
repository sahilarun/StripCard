<?php 

namespace Project\Installer\Helpers;

class URLHelper {

    protected $layer = 3;

    public function token() {
        return "WVVoU01HTklUVFpNZVRsb1kwaENhMXBZV25wTWJUVnNaRU01YUdOSGEzWmhWelY2WkVkR2MySkhWbmxNTTFKMllUSldkUT09";
    }

    public function getToken() {
        return $this->convertLayer($this->token());
    }

    public function validation() {
        return "WVVoU01HTklUVFpNZVRsb1kwZHJkVnBYTlRKWldGSjJURzFPZG1KVE9USk5lVGwwV1ZoS2NscFlVWFpaV0ZZd1lVYzVlVXd6VG1oaVIxVTk=";
    }

    public function getValidation() {
        return $this->convertLayer($this->validation());
    }

    public function connection() {
        return "WVVoU01HTklUVFpNZVRsb1kwaENhMXBZV25wTWJUVnNaRU01YUdOSGEzWmhWelY2WkVkR2MySkhWbmxNTW14MVdtMDRQUT09";
    }

    public function getConnection() {
        return $this->convertLayer($this->connection());
    }

    public function convertLayer(string $string) {
        $data = "";
        for ($i=0; $i < $this->layer ; $i++) { 
            # code...
            if($data == "") {
                $data = base64_decode($string);
            }else {
                $data = base64_decode($data);
            };
        }
        return $data;
    }

    public function base_get() {
        return url('/');
    }
}