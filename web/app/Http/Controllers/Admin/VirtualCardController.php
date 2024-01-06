<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\VirtualCardApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VirtualCardController extends Controller
{
    public function cardApi()
    {
        $page_title = "Setup Virtual Card Api";
        $api = VirtualCardApi::first();
        return view('admin.sections.virtual-card.api',compact(
            'page_title',
            'api',
        ));
    }
    public function cardApiUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'stripe_public_key'         => 'required_if:api_method,stripe',
            'stripe_secret_key'             => 'required_if:api_method,stripe',
            'stripe_url'                => 'required_if:api_method,stripe',
            'card_details'              => 'required|string',
            'image'                     => "nullable|mimes:png,jpg,jpeg,webp,svg",
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request->merge(['name'=>$request->api_method]);
        $data = array_filter($request->except('_token','api_method','_method'));
        $api = VirtualCardApi::first();
        $api->card_details = $request->card_details;
        $api->config = $data;

        if ($request->hasFile("image")) {
            try {
                $image = get_files_from_fileholder($request, "image");
                $upload_file = upload_files_from_path_dynamic($image, "card-api");
                $api->image = $upload_file;
            } catch (Exception $e) {
                return back()->with(['error' => ['Ops! Faild to upload image.']]);
            }
        }
        $api->save();

        return back()->with(['success' => ['Card API has been updated.']]);
    }

    public function transactionLogs()
    {
        $page_title = "Virtual Card Logs";
        $transactions = Transaction::with(
          'user:id,firstname,lastname,email,username,full_mobile',
            'currency:id,name',
        )->where('type', 'VIRTUAL-CARD')->latest()->paginate(20);

        return view('admin.sections.virtual-card.logs', compact(
            'page_title',
            'transactions'
        ));
    }
}
