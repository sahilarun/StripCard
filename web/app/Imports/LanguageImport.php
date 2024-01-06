<?php

namespace App\Imports;

use Maatwebsite\Excel\Facades\Excel;
use Exception;

class LanguageImport
{
    protected $array;
    protected $column_data = false;

    protected const KEY_STRING = 'key';

    public function toArray($file) {
        $array = Excel::toArray($this,$file);
        $this->array = $array;
        return $this;
    }

    public function columnData() {
        if(!is_array($this->array)) throw new Exception('Pelase Call toArray() Function Before Calling columnData()');
        $array = $this->array;

        $languages = [];
        if(count($array) > 0) {
            $header  = $array[0][0];
            if(strtolower($header[0]) != self::KEY_STRING) {
                throw new Exception('File upload with wrong format. Make sure the file have language key and key title is "Key"');
            }
            foreach($header as $key => $item) {
                if($item == null) break;
                foreach($array as $sheet) {
                    array_shift($sheet);
                    foreach($sheet as $row) {
                        $value = $row[$key] ?? "";
                        $languages[$item][]    = trim($value);

                    }
                }
            }
        }

        $this->array = $languages;
        $this->column_data = true;
        return $this;
    }

    public function keyValue() {
        if($this->column_data == false) throw new Exception('Pelase Call columnData() Function Before Calling keyValue()');
        $data = $this->array;
        $languages_keys = array_shift($data);
        $language_key_value = [];
        foreach($languages_keys as $key => $item) {
            foreach($data as $language_code => $values) {
                $language_key_value[$language_code][$item]  = $values[$key];
            }
        }
        return $language_key_value;
    }

    public function getArray() {
        if(is_array($this->array)) return $this->array;

        throw new Exception('Pelase Call columnData() Function Before Calling getArray()');
    }
}
