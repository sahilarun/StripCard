<?php

namespace App\Traits;

use App\Models\Admin\Currency;
use App\Models\UserWallet;
use Exception;

trait ControlDynamicInputFields {

    public function generateValidationRules($kyc_fields) {
        $validation_rules = [];
        foreach($kyc_fields ?? [] as $item) {
            $validation_rules[$item->name] = ($item->required) ? "required" : "";
            $min = $item->validation->min ?? 0;
            $max = $item->validation->max ?? 0;
            if($item->type == "text" || $item->type == "textarea") {
                $validation_rules[$item->name]  .= "|string|min:". $min ."|max:". $max;
            }elseif($item->type == "file") {
                $max = $max * 1024;
                $mimes = $item->validation->mimes ?? [];
                $mimes = implode(",",$mimes);
                $validation_rules[$item->name]  .= "|file|mimes:". $mimes ."|max:".$max;
            }
        }
        return $validation_rules;
    }

    public function placeValueWithFields($kyc_fields,$form_data) {
        $fields_with_value = [];
        foreach($kyc_fields ?? [] as $key => $item) {
            if($item->type == "text" || $item->type == "textarea") {
                $vlaue = $form_data[$item->name] ?? "";
            }elseif($item->type == "file") {
                $form_file = $form_data[$item->name] ?? "";
                if(is_file($form_file)) {
                    $get_file_link = upload_file($form_file,"junk-files");
                    $upload_file = upload_files_from_path_dynamic([$get_file_link['dev_path']],"kyc-files");
                    delete_file($get_file_link['dev_path']);
                    $vlaue = $upload_file;
                }
            }elseif($item->type == "select") {
                $vlaue = $form_data[$item->name] ?? "";
            }

            if(isset($form_data[$item->name])) {
                $fields_with_value[$key] = json_decode(json_encode($item),true);
                $fields_with_value[$key]['value'] = $vlaue;
            }
        }
        $this->removeUserKycFiles();
        return $fields_with_value;
    }


    public function generatedFieldsFilesDelete($kyc_fields_with_value) {

        $files_link = [];
        $files_path = get_files_path("kyc-files");
        foreach($kyc_fields_with_value as $item) {
            if($item['type'] == "file") {
                $link = $files_path . "/" . $item['value'] ?? "";
                array_push($files_link,$link);
            }
        }
        delete_files($files_link);
    }

    public function removeUserKycFiles() {
        $user_kyc = auth()->user()->kyc;
        if($user_kyc) {
            if($user_kyc->data) {
                foreach($user_kyc->data ?? [] as $item) {
                    if($item->type == "file") {
                        $file_name = $item->value ?? "";
                        $file_path = get_files_path("kyc-files");
                        if(!empty($file_name)) {
                            $file_link = $file_path . "/" . $file_name;
                            delete_file($file_link);
                        }
                    }
                }
            }
        }
    }
}