<?php 

namespace Project\Installer\Helpers;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Process;

class DBHelper {

    public function create(array $data) {

        $this->updateEnv([
            // 'APP_NAME'          => $data['app_name'],
            'DB_CONNECTION'     => "mysql",
            'DB_HOST'           => $data['host'],
            'DB_PORT'           =>"3306",
            'DB_DATABASE'       => $data['db_name'],
            'DB_USERNAME'       => $data['db_user'],
            'DB_PASSWORD'       => $data['db_user_password'],
        ]);
        
        $this->setStepSession();
        $this->saveDataInSession($data);

        $helper = new Helper();
        $helper->cache($data);
    }

    public function updateEnv(array $replace_array) {
        $array_going_to_modify  = $replace_array;

        if (count($array_going_to_modify) == 0) {
            return false;
        }

        $env_file = App::environmentFilePath();
        $env_content = $_ENV;

        $update_array = ["APP_ENV" => App::environment()];

        foreach ($env_content as $key => $value) {

            foreach ($array_going_to_modify as $modify_key => $modify_value) {

                if(!array_key_exists($modify_key,$env_content) && !array_key_exists($modify_key,$update_array)) {
                    // $update_array[$modify_key] = '"'.$modify_value.'"';
                    $update_array[$modify_key] = $this->setEnvValue($modify_key,$modify_value);
                    break;
                }

                if ($key == $modify_key) {
                    // $update_array[$key] = '"'.$modify_value.'"';
                    $update_array[$key] = $this->setEnvValue($key,$modify_value);
                    break;
                } else {
                    // $update_array[$key] = '"'.$value.'"';
                    $update_array[$key] = $this->setEnvValue($key,$value);
                }
            }
        }

        $string_content = "";
        foreach ($update_array as $key => $item) {
            $line = $key . "=" . $item;
            $string_content .= $line . "\n\r";
        }

        sleep(2);

        file_put_contents($env_file, $string_content);
    }

    public function setEnvValue($key,$value) {
        if($key == "APP_KEY") {
            return $value;
        }
        return '"'.$value.'"';
    }

    public function saveDataInSession($data) {
        session()->put('database_config_data',$data);
    }

    public static function getSessionData() {
        return session('database_config_data');
    }

    public function setStepSession() {
        session()->put("database_config","PASSED");
    }

    public static function step($step = 'database_config') {
        return session($step);
    }

    public function migrate() {
        Artisan::call("migrate:fresh --seed");
        // Artisan::call("php artisan passport:install");
        // self::execute("composer update");
        self::execute("php artisan migrate");
        self::execute("php artisan passport:install");

        $this->setMigrateStepSession();
    }

    public function setMigrateStepSession() {
        session()->put('migrate','PASSED');
    }

    public function updateAccountSettings(array $data) {
        $admin = DB::table('admins')->first();
        if(!$admin) {
            DB::table('admins')->insert([
                'firstname'     => $data['f_name'],
                'lastname'      => $data['l_name'],
                'password'      => password_hash($data['password'],PASSWORD_DEFAULT),
                'email'         => $data['email'],
            ]);
        }else {
            DB::table("admins")->where('id',$admin->id)->update([
                'firstname'     => $data['f_name'],
                'lastname'      => $data['l_name'],
                'password'      => password_hash($data['password'],PASSWORD_DEFAULT),
                'email'         => $data['email'],
            ]);
        }

        $helper = new Helper();
        $helper->cache($data);
        $helper->connection($helper->cache());

        $client_host = parse_url(url('/'))['host'];
        $filter_host = preg_replace('/^www\./', '', $client_host);

        if(Schema::hasTable('script')) {
            DB::table('script')->truncate();
            DB::table('script')->insert([
                'client'        => $filter_host,
                'signature'     => $helper->signature($helper->cache()),
            ]);
        }
        if(Schema::hasTable('basic_settings')) {
            try{
                DB::table('basic_settings')->where('id',1)->update([
                    'site_name'     => $helper->cache()['app_name'] ?? "",
                ]);
            }catch(Exception $e) {
                //handle error
            }
        }

        $db = new DBHelper();
        $db->updateEnv([
            'PURCHASE_CODE' => $helper->cache()['code'] ?? "",
        ]);

        $helper->generateAppKey();
        $this->setAdminAccountStepSession();
    }

    public function setAdminAccountStepSession() {
        session()->put('admin_account','PASSED');
    }

    public static function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            throw new Exception($cmd . " - " . $processOutput);
        }

        return $processOutput;
    }
}