<?php 

namespace Project\Installer\Helpers;

class ConfigHelper {

    public function get() 
    {
        $config_file_path = $this->getConfigFilePath();
        $config_array = include $config_file_path;
        return $config_array;
    }

    public function getConfigFilePath() {
        return resource_path('installer/src/config/installer.php');
    }
}