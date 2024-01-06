<?php 

$minimum_php_version = "8.0.13";

return [

    /*
    |--------------------------------------------------------------------------
    | Installment Requirements
    |--------------------------------------------------------------------------
    |
    |Installment requirements server/database. This is the default values for process installation. 
    |This variable contains installment related all require stuff details like server, database, 
    |server version, database engine, database version, server extensions etc.
    |
    */

    'requirements'      => [
        'php'   => [
            'min_version'    => $minimum_php_version,
            'extensions'    => [
                'openssl',
                'pdo',
                'mbstring',
                'tokenizer',
                'json',
                'gd',
                'curl',
                'zip',
                'zlib',
            ],
        ],
        'apache'    => [
            'mod_rewrite',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is default folder permission for process installation.
    |
    */

    'permissions'   => [
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775',
    ],

    'marketplace'       => 'codecanyon',

];