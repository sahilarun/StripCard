<?php 

namespace Project\Installer\Helpers;

use Exception;

class RequirementHelper {

    public $error_helper;
    public $config;
    public $requirements;
    public $requirements_status;

    public function __construct(ErrorHelper $error_helper, ConfigHelper $config)
    {
        $this->error_helper = $error_helper;
        // $this->config = $this->getConfig();
        $this->config = $config->get();
        $this->requirements = $this->config['requirements'] ?? [];
    }

    public function getRequirementStatus() {
        $php_requirements       = $this->handlePHPRequirements();
        $server_requirements    = $this->handleServerRequirements();

        $requirements_status = [
            'php'   => $php_requirements,
            'server'    => $server_requirements,
        ];

        $this->requirements_status = $requirements_status;

        // Set Step Session
        $this->setStepSession();

        return $requirements_status;
    }

    public function setStepSession() {

        $requirements_status = $this->requirements_status;

        $version_status = [data_get($requirements_status,'php.version.status')];
        $extensions_status = data_get($requirements_status,'php.extensions.*.status');
        $server_modules_status = data_get($requirements_status,'server.*.status');

        $all_status = array_merge($version_status,$extensions_status,$server_modules_status);

        if(in_array(false,$all_status)) { // If one false value is available
            session()->put('requirement',false);
        }else {
            session()->put('requirement',"PASSED");
        }
    }

    public static function step() {
        return session('requirement');
    }

    public function handleServerRequirements() {

        $server_software_info_array = explode(" ",$_SERVER['SERVER_SOFTWARE']);
        $software_info = array_shift($server_software_info_array);

        $software_info_array = explode("/",$software_info);

        $software_name = array_shift($software_info_array);
        $software_version = array_pop($software_info_array);

        $server_requirement_status = [];
        if(strtolower($software_name) == 'apache') {
            // Need to check apache server requirements
            $server_requirement_status = $this->checkApacheRequirements();
        }

        return $server_requirement_status;
    }


    public function checkApacheRequirements() {
        $apache_requirements = $this->requirements['apache'] ?? [];

        $apache_requirement_status = [];
        if(function_exists("apache_get_modules")) {
            foreach($apache_requirements as $key => $item) {
                $apache_requirement_status[$key] = [
                    'name'      => $item,
                    'status'    => false,
                    'message'   => "",
                ];
    
                if(in_array($item,apache_get_modules())) {
                    $apache_requirement_status[$key]['status'] = true;
                }else {
                    $apache_requirement_status[$key]['message'] = "Module " . $item . " is required!";
                }
            }
        }

        return $apache_requirement_status;
    }

    public function handlePHPRequirements() {
        $php_requirements = $this->requirements['php'] ?? [];
        if(count($php_requirements) == 0 || !isset($php_requirements['min_version']) || !isset($php_requirements['extensions'])) {
            throw new Exception('Invalid Server Requirement Configuration File');
        }

        $php_version_status = $this->checkPHPVersion($php_requirements['min_version']);
        $php_extension_status = $this->checkPHPExtensions($php_requirements['extensions']);

        return [
            'version'       => $php_version_status,
            'extensions'    => $php_extension_status,
        ];
    }

    public function checkPHPVersion(string $require_version) {

        $data = [
            'status'        => false,
            'server_v'      => phpversion(),
            'requirement_v' => $require_version,
            'message'       => "",
        ];

        if($data['server_v'] >= $data['requirement_v']) {
            $data['status']  = true;
        }else {
            $data['message'] = "Server PHP version must not be less then ". $require_version;
        }

        return $data;
    }

    public function checkPHPExtensions(array $require_extensions) {

        $extensions_status = [];
        foreach($require_extensions as $key => $item) {

            $extensions_status[$key] = [
                'name'      => $item,
                'status'    => false,
                'message'   => "",
            ];

            if(extension_loaded($item)) {
                $extensions_status[$key]['status'] = true;
            }else {
                $extensions_status[$key]['message'] = "Extension " . $item . " is required!";
            }

        }
        return $extensions_status;
    }

    public function requirementConfigIsInvalid() {
        $requirements = $this->requirements['requirements'] ?? null;
        if(!is_array($requirements)) return false;
        return true;
    }
}