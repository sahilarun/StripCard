<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{

    public function storeFile(Request $request) {
        $data = [];
        if($request->hasFile('fileholder_files')) {

            $validator = Validator::make($request->all(),[
                'fileholder_files' => 'required|mimes:'.$request->mimes,
            ]);

            if($validator->fails()) {
                $data['error']  = $validator->errors()->all();
                $data['status'] = false;
                return response()->json($data,400);
            }

            $validated = $validator->safe()->all();

            $file_holder_files = $validated['fileholder_files'];
            $file_ext = $file_holder_files->getClientOriginalExtension();
            $file_store_name = Str::uuid() . "." . $file_ext;
            $data['path']   = asset('public/fileholder/img/');
            $data['file_name']  =  $file_store_name;
            $data['file_link']  = $data['path'] . "/" . $data['file_name'];
            $data['file_type']  = $file_holder_files->getClientMimeType();
            $data['file_old_name']  = $file_holder_files->getClientOriginalName();

            $data['status'] = true;
            try{
                File::move($file_holder_files,public_path('/fileholder/img/'.$file_store_name));
                chmod(public_path('/fileholder/img/'.$file_store_name), 0644);
            }catch(Exception $e) {
                return print_r($e);
                $data['status'] = false;
            }
        }else {
            $data['status'] = false;
            $data['error'] = "Something went worng! File is not detected.";
        }
        return response()->json($data,200);
    }

    public function removeFile(Request $request) {
        $validator = Validator::make($request->all(),[
            'file_info' => 'required|json',
        ]);

        if($validator->fails()) {
            $data['error']  = $validator->errors()->all();
            $data['status'] = false;
            return response()->json($data,400);
        }

        $validated = $validator->safe()->all();

        $file_path = '/fileholder/img';

        $file_info = json_decode($validated['file_info']);
        $data['status'] = true;
        try {
            FIle::delete(public_path($file_path.'/'.$file_info->file_name));
            $data['message'] = "File Deleted Successfully!";
        }catch(Exception $e) {
            $data['status'] = false;
            $data['error'] = $e;
            $data['message'] = "Something Went Wrong! Please try again.";
        }

        $data['file_info'] = $file_info;

        return response()->json($data,200);

    }
}
