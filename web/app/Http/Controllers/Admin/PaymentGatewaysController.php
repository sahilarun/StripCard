<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Models\Admin\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Constants\PaymentGatewayConst;
use App\Http\Helpers\Response;

class PaymentGatewaysController extends Controller
{

    /**
     * Function For Redirect Slug Wise Current Function
     * @param string $param
     * @param string|array|object $param_two
     * @param string|array|object $param_three
     * @return method
     */
    public function getSolution($param, $param_two = null, $param_three = null) {
        return $this->$param($param_two,$param_three);
    }


    /**
     * Register Slug And Type Wise All Function
     * @param string $type
     * @return array
     *
     */
    public function registerSlugTypes($type) {
        $slug_types = [
            'view' => [
                'add-money' => [
                    'automatic' => 'automaticAddMoneyView',
                    'manual'    => 'manualAddMoneyView',
                ],
                'money-out' => [
                    'manual'    => 'manualMoneyOutView',
                ],
            ],
            'edit'  => [
                'add-money' => [
                    'automatic' => 'automaticAddMoneyEdit',
                    'manual'    => 'manualAddMoneyEdit',
                ],
                'money-out'     => [
                    'manual'    => 'manualMoneyOutEdit',
                ],
            ],
            'update'    => [
                'add-money' => [
                    'automatic' => 'automaticAddMoneyUpdate',
                    'manual'    => 'manualAddMoneyUpdate',
                ],
                'money-out'     => [
                    'manual'    => 'manualMoneyOutUpdate',
                ],
            ],
            'store'     => [
                'add-money' => [
                    'automatic' => 'automaticAddMoneyStore',
                    'manual'    => 'manualAddMoneyStore',
                ],
                'money-out'     => [
                    'manual'    => 'manualMoneyOutStore',
                ],
            ],
            'create'    => [
                'add-money'   => [
                    'manual'    => 'manualAddMoneyCreate',
                ],
                'money-out'     => [
                    'manual'    => 'manualMoneyOutCreate',
                ],
            ],
        ];

        return $slug_types[$type];
    }


    /**
     * Distribute Functions Based on slug and type
     * @param string $slug
     * @param string $type
     * @return Function
     */
    public function paymentGatewayView($slug,$type) {
        $view_slug_types = $this->registerSlugTypes('view');

        if(!array_key_exists($slug,$view_slug_types) || !array_key_exists($type,$view_slug_types[$slug])) {
            abort(404);
        }

        return $this->getSolution($view_slug_types[$slug][$type]);
    }


    /**
     * Display Add Money Automatic Gateways
     * @return view
     */
    public function automaticAddMoneyView() {
        $page_title = "Automatic Add Money";
        $payment_gateways = PaymentGateway::addMoney()->automatic()->get();
        return view('admin.sections.payment-gateways.add-money.automatic.index',compact(
            'page_title',
            'payment_gateways',
        ));
    }


    /**
     * Display Add Money Manual Gateways
     * @return view
     */
    public function manualAddMoneyView() {
        $page_title = "Manual Add Money";
        $payment_gateways = PaymentGateway::addMoney()->manual()->get();

        return view('admin.sections.payment-gateways.add-money.manual.index',compact(
            'page_title',
            'payment_gateways',
        ));
    }


    /**
     * Display Money Out Manual Gateways
     * @return view
     */
    public function manualMoneyOutView() {
        $page_title = "Money Out";
        $payment_gateways = PaymentGateway::moneyOut()->manual()->get();
        return view('admin.sections.payment-gateways.money-out.manual.index',compact(
            'page_title',
            'payment_gateways',
        ));
    }


    /**
     * Distribute The Specific Function Based on slug and type for View
     * @param string $slug
     * @param string $type
     * @param string $alias
     * @return method
     */
    public function paymentGatewayEdit($slug, $type, $alias) {
        $edit_slug_types = $this->registerSlugTypes('edit');

        if(!array_key_exists($slug,$edit_slug_types) || !array_key_exists($type,$edit_slug_types[$slug])) {
            abort(404);
        }

        return $this->getSolution($edit_slug_types[$slug][$type],$alias);
    }


    /**
     * Display The Edit Page of Add Money Automatic Gateway
     * @return view
     *
     */
    public function automaticAddMoneyEdit($alias) {
        $page_title = "Automatic Add Money Edit";
        $gateway = PaymentGateway::addMoney()->automatic()->gateway($alias)->firstOrFail();
        return view('admin.sections.payment-gateways.add-money.automatic.edit',compact(
            'page_title',
            'gateway',
        ));
    }


    /**
     * Display The Edit Page of Add Money Manual Gateway
     * @return view
     */
    public function manualAddMoneyEdit($alias) {
        $page_title = "Manual Add Money Edit";
        $payment_gateway = PaymentGateway::addMoney()->manual()->gateway($alias)->firstOrFail();
        return view('admin.sections.payment-gateways.add-money.manual.edit',compact(
            'page_title',
            'payment_gateway',
        ));
    }


    /**
     * Display The Edit Page of Money Out Manual Gateway
     * @return view
     */
    public function manualMoneyOutEdit($alias) {
        $page_title = "Money Out Edit";
        $payment_gateway = PaymentGateway::moneyOut()->manual()->gateway($alias)->firstOrFail();
        return view('admin.sections.payment-gateways.money-out.manual.edit',compact(
            'page_title',
            'payment_gateway',
        ));
    }

    /**
     * Distribute The Specific Function Based on slug and type for Store
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @param string $type
     * @return method
     */
    public function paymentGatewayStore(Request $request,$slug, $type) {
        $edit_slug_types = $this->registerSlugTypes('store');

        if(!array_key_exists($slug,$edit_slug_types) || !array_key_exists($type,$edit_slug_types[$slug])) {
            abort(404);
        }

        return $this->getSolution($edit_slug_types[$slug][$type],$request);
    }


    /**
     * Store New Add Money Automatic Gateway
     * @param \Illuminate\Http\Request $request
     */
    public function automaticAddMoneyStore(Request $request) {
        $gateway_name = $request->gateway_name;
        $validator = Validator::make($request->all(),[
            'gateway_name'              => ['required','string','max:60',Rule::unique('payment_gateways','alias')->where(function($query) use ($gateway_name) {
                $alias = Str::slug($gateway_name);
                $query->where('slug',PaymentGatewayConst::add_money_slug())->where('type',PaymentGatewayConst::AUTOMATIC)->where('alias',$alias);
            })],
            'gateway_title'             => 'required|string|max:60',
            'supported_currencies'      => 'required|array',
            'supported_currencies.*'    => 'string|max:30',
            'title'                     => 'required|array',
            'title.*'                   => 'string|max:60',
            'name'                      => 'required|array',
            'name.*'                    => 'string|max:60',
            'value'                     => 'nullable|array',
            'value.*'                   => 'nullable|string|max:255',
            'image'                     => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
        ]);

        $validator->after(function ($validator) use ($gateway_name) {
            // Search Gateway is unique or not
            if(PaymentGateway::addMoney()->automatic()->gateway(Str::slug($gateway_name))->exists()) {
                $validator->errors()->add(
                    'gateway_name', 'The gateway name has already been taken.'
                );
            }
        });

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','automatic-add-money');
        }
        $validated = $validator->validate();

        // Generating input fields collection
        $input_fields = [];
        foreach($validated['title'] as $key => $title) {
            $input_fields[] = [
                'label'         => $title,
                'placeholder'   => "Enter " . $title,
                'name'          => ($validated['name'][$key] == null) ? Str::slug($title) : Str::slug($validated['name'][$key]),
                'value'         => $validated['value'][$key] ?? "",
            ];
        }
        $validated['credentials'] = $input_fields;

        $validated['slug']          = Str::slug("Add Money");
        $validated['type']          = "AUTOMATIC";
        $validated['name']          = $validated['gateway_name'];
        $validated['title']         = $validated['gateway_title'];
        $validated['alias']         = Str::slug($validated['gateway_name']);
        $validated['last_edit_by']  = Auth::user()->id;

        $validated = Arr::except($validated,['value','gateway_name','gateway_title']);

        $last_record_of_max_code = PaymentGateway::max('code') ?? 100;
        $validated['code']  = set_payment_gateway_code($last_record_of_max_code);

        // Check Image File is Available or not
        if($request->hasFile('image')) {
            $image = get_files_from_fileholder($request,'image');
            $upload = upload_files_from_path_dynamic($image,'payment-gateways');
            $validated['image'] = $upload;
        }

        try{
            PaymentGateway::create($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway added successfully!']]);
    }

    /**
     * Function for update payment gateway status active/deactive
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function paymentGatewayStatusUpdate(Request $request) {

        $validator = Validator::make($request->all(),[
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->validate();
        $item_id = $validated['data_target'];

        $payment_gateway = PaymentGateway::find($item_id);
        if(!$payment_gateway) {
            $error = ['error' => ['Payment gateway not found!.']];
            return Response::error($error,null,404);
        }

        try{
            $payment_gateway->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Payment gateway status updated successfully!']];
        return Response::success($success,null,200);
    }


    /**
     * Distribute The Specific Function Based on slug and type for Update
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @param string $type
     * @param string $alias
     * @return method
     */
    public function paymentGatewayUpdate(Request $request,$slug, $type, $alias) {
        $edit_slug_types = $this->registerSlugTypes('update');

        if(!array_key_exists($slug,$edit_slug_types) || !array_key_exists($type,$edit_slug_types[$slug])) {
            abort(404);
        }

        return $this->getSolution($edit_slug_types[$slug][$type],$request,$alias);
    }

     /**
     * Function for Automatic Add Money Update Based on alias
     * @param \Illuminate\Http\Request $request
     * @param string $alias
     */
    public function automaticAddMoneyUpdate(Request $request,$alias) {
        $validated_gateway = Validator::make(['alias' => $alias, 'mode' => $request->mode],[
            'alias'     => 'exists:payment_gateways',
            'mode'      => "required|string|in:".PaymentGatewayConst::ENV_SANDBOX.",".PaymentGatewayConst::ENV_PRODUCTION,
        ],[
           'alias.exists'   => "Selected payment gateway is invalid!",
        ])->validate();

        $gateway = PaymentGateway::addMoney()->automatic()->gateway($alias)->first();
        $gateway_currencies = $gateway->currencies()->get();
        $available_currencies = $gateway_currencies->pluck("currency_code")->toArray();

        $credentials_validation_rules = [];
        $credentials = $gateway->credentials;
        foreach($credentials as $values) {
            $values = (array) $values;
            $credentials_validation_rules[$values['name']] = "nullable|string";
        }

        $credentials_input_fields = array_keys($credentials_validation_rules);
        $validated_credentials = Validator::make($request->only($credentials_input_fields),$credentials_validation_rules)->validate();

        $credentials_array = json_decode(json_encode($credentials),true);
        foreach($credentials_array as $key => $item) {
            foreach($validated_credentials as $input_name => $value) {
                if($input_name == $item['name']) {
                    $item['value'] = $value;
                }
                $credentials_array[$key] = $item;
            }
        }

        try{
            $image = $gateway->image;
            if($request->hasFile('image')) {
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_dynamic($image,'payment-gateways',$gateway->image);
                $image = $upload_image;
            }
            $gateway->update([
                'credentials'   => $credentials_array,
                'image'         => $image,
                'env'           => $validated_gateway['mode'],
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        $gateway_supported_currency = json_decode(json_encode($gateway->supported_currencies),true);

        $form_input_fields_validation_rules = [
            'min_limit'         => 'nullable|numeric',
            'max_limit'         => 'nullable|numeric',
            'fixed_charge'      => 'nullable|numeric',
            'percent_charge'    => 'nullable|numeric',
            'rate'              => 'nullable|numeric',
            'currency_symbol'   => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,svg,webp',
        ];
        $input_field_base_name = "gateway_currency";

        $gateway_currency_validation_rules = [];
        foreach($request->only([$input_field_base_name]) as $item) {
            if(!is_array($item)) break;
            foreach($item as $currency => $fields_value) {
                if(!is_array($fields_value)) break;
                if(in_array($currency,$gateway_supported_currency)) {
                    foreach($fields_value as $input_key => $input_value) {
                        if(array_key_exists($input_key,$form_input_fields_validation_rules)) {
                            $validation_rule_key = $input_field_base_name.".".$currency.".".$input_key;
                            $validation_rule = $form_input_fields_validation_rules[$input_key];

                            $gateway_currency_validation_rules[$validation_rule_key]    = $validation_rule;
                        }
                    }
                }
            }
        }

        $validated = Validator::make($request->only($input_field_base_name),$gateway_currency_validation_rules)->validate();
        $data_ready_to_work  = [];
        foreach($validated[$input_field_base_name] ?? [] as $currency => $item) {

            $item['currency_code']      = $currency;
            $item['name']               = $gateway->name . " " . $currency;
            $item['alias']              = PaymentGatewayConst::add_money_slug() . "-" . Str::slug($gateway->name . " " . $currency . " " . $gateway->type);
            $item['payment_gateway_id'] = $gateway->id;
            $item['rate']               = $item['rate'] ?? 1;
            $item['image']              = null;

            if(in_array($currency,$available_currencies)) {
                $old_image      = $gateway_currencies->where('currency_code',$currency)->first()->image;
                $item['image']  = $old_image;
            }

            if($request->hasFile($input_field_base_name.".".$currency."."."image")) {
                $image = get_files_from_fileholder($request,$input_field_base_name.".".$currency."."."image");
                if(in_array($currency,$available_currencies)) {
                    $old_image = $gateway_currencies->where('currency_code',$currency)->first()->image;
                    $upload_image = upload_files_from_path_dynamic($image,'payment-gateways',$old_image);
                }else {
                    $upload_image = upload_files_from_path_dynamic($image,'payment-gateways');
                }
                $item['image']  = $upload_image;
            }

            $data_ready_to_work[] = $item;

        }

        try{
            PaymentGatewayCurrency::where('payment_gateway_id',$gateway->id)->upsert($data_ready_to_work,['alias']);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);

    }


    /**
     * Distribute The Specific Function Based on slug and type for Create
     * @param string $slug
     * @param string $type
     * @return method
     */
    public function paymentGatewayCreate($slug,$type) {
        $edit_slug_types = $this->registerSlugTypes('create');

        if(!array_key_exists($slug,$edit_slug_types) || !array_key_exists($type,$edit_slug_types[$slug])) {
            abort(404);
        }

        return $this->getSolution($edit_slug_types[$slug][$type]);
    }

    /**
     * Function for create new Manual Add Money Gateway
     */
    public function manualAddMoneyCreate() {
        $page_title = "Manual Add Money";
        return view('admin.sections.payment-gateways.add-money.manual.create',compact(
            'page_title',
        ));
    }

    /**
     * Function for store new manual payment gateway
     * @param \Illuminate\Http\Request $request
     * @return view
     */
    public function manualAddMoneyStore(Request $request) {

        $gateway_name = $request->gateway_name;
        $validator = Validator::make($request->all(),[
            'gateway_name'          => ['required','string','max:60',Rule::unique('payment_gateways','alias')->where(function($query) use ($gateway_name) {
                $alias = Str::slug($gateway_name);
                $query->where('slug',PaymentGatewayConst::add_money_slug())->where('type',PaymentGatewayConst::MANUAL)->where('alias',$alias);
            })],
            'desc'                  => 'nullable|string|max:10000',
            'label'                 => 'nullable|array',
            'label.*'               => 'nullable|string|max:50',
            'input_type'            => 'nullable|array',
            'input_type.*'          => 'nullable|string|max:20',
            'min_char'              => 'nullable|array',
            'min_char.*'            => 'nullable|numeric',
            'max_char'              => 'nullable|array',
            'max_char.*'            => 'nullable|numeric',
            'field_necessity'       => 'nullable|array',
            'field_necessity.*'     => 'nullable|string|max:20',
            'file_extensions'       => 'nullable|array',
            'file_extensions.*'     => 'nullable|string|max:255',
            'file_max_size'         => 'nullable|array',
            'file_max_size.*'       => 'nullable|numeric',
            'image'                 => 'nullable|image|mimes:jpg,png,svg,jpeg,webp',
            'currency_code'         => 'required|string|max:10',
        ]);

        $validator->after(function ($validator) use ($gateway_name) {
            // Search Gateway is unique or not
            if(PaymentGateway::addMoney()->manual()->gateway(Str::slug($gateway_name))->exists()) {
                $validator->errors()->add(
                    'gateway_name', 'The gateway name has already been taken.'
                );
            }
        });

        $validated = $validator->validate();

        $validated['alias']                 = Str::slug($validated['gateway_name']);
        $validated['name']                  = $validated['gateway_name'];
        $validated['slug']                  = Str::slug(PaymentGatewayConst::ADDMONEY);
        $validated['title']                 = $validated['name'] . " " . "Gateway";
        $validated['type']                  = PaymentGatewayConst::MANUAL;
        $validated['last_edit_by']          = Auth::user()->id;
        $validated['supported_currencies']  = [$validated['currency_code']];

        $last_record_of_max_code = PaymentGateway::max('code') ?? 100;
        $validated['code']  = set_payment_gateway_code($last_record_of_max_code);

        $validated['input_fields']      = decorate_input_fields($validated);

        $validated = Arr::except($validated,['gateway_name','label','input_type','min_char','max_char','field_necessity','file_extensions','file_max_size','currency_code']);

        // validation payment gateway currencies
        $currency_validator = Validator::make($request->all(),[
            'min_limit'         => 'required|numeric',
            'max_limit'         => 'required|numeric',
            'fixed_charge'      => 'required|numeric',
            'percent_charge'    => 'required|numeric',
            'rate'              => 'required|numeric',
            'currency_code'     => 'required|string|max:10',
            'currency_symbol'   => 'nullable|string|max:10',
        ]);

        $currency_validated = $currency_validator->validate();
        $currency_validated['name'] = $validated['name'] . " " . $currency_validated['currency_code'];
        $currency_validated['alias'] = Str::slug($currency_validated['name'] . " " . PaymentGatewayConst::MANUAL);

        // uplaod image if have
        if($request->hasFile('image')) {
            try{
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_dynamic($image,'payment-gateways');
                $validated['image'] = $upload_image;
            }catch(Exception $e) {
                return back()->with(['error' => ['Image upload faild! Please try again.']]);
            }
        }

        // Insert new manual payment gateway
        try{
            $validated['input_fields']  = json_encode($validated['input_fields']);
            $validated['supported_currencies'] = json_encode($validated['supported_currencies']);
            $payment_gateway_id = PaymentGateway::insertGetId($validated);
            $currency_validated['payment_gateway_id'] = $payment_gateway_id;
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        // insert gateway currency
        try{
            PaymentGatewayCurrency::create($currency_validated);
        }catch(Exception $e) {
            // if fails delete the payment gateway that added lastly
            PaymentGateway::find($payment_gateway_id)->delete();
            // Delete payment gateway image
            $image_link = $validated['image'] ?? null;
            if($image_link) {
                $image_link = get_files_path('payment-gateways') . "/" . $validated['image'];
                delete_file($image_link);
            }
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway added successfully!']]);

    }

    /**
     * Function for Specific Update Manual Add Money Information
     * @param \Illuminate\Http\Request $request
     * @param string $alias
     */
    public function manualAddMoneyUpdate(Request $request,$alias) {

        // Find gateway is available or not
        $gateway = PaymentGateway::addMoney()->manual()->gateway($alias)->first();
        if(!$gateway) {
            return back()->with(['error' => ['Opps! Payment gateway not found!']]);
        }

        // Validate Data
        $gateway_name = $request->gateway_name;
        $validator = Validator::make($request->all(),[
            'gateway_name'          => ['required','string','max:60',Rule::unique('payment_gateways','alias')->where(function($query) use ($gateway_name, $gateway) {
                $alias = Str::slug($gateway_name);
                $query->whereNot('id',$gateway->id)->where('slug',PaymentGatewayConst::add_money_slug())->where('type',PaymentGatewayConst::MANUAL)->where('alias',$alias);
            })],
            'desc'                  => 'nullable|string|max:10000',
            'label'                 => 'nullable|array',
            'label.*'               => 'nullable|string|max:50',
            'input_type'            => 'nullable|array',
            'input_type.*'          => 'nullable|string|max:20',
            'min_char'              => 'nullable|array',
            'min_char.*'            => 'nullable|numeric',
            'max_char'              => 'nullable|array',
            'max_char.*'            => 'nullable|numeric',
            'field_necessity'       => 'nullable|array',
            'field_necessity.*'     => 'nullable|string|max:20',
            'file_extensions'       => 'nullable|array',
            'file_extensions.*'     => 'nullable|string|max:255',
            'file_max_size'         => 'nullable|array',
            'file_max_size.*'       => 'nullable|numeric',
            'image'                 => 'nullable|image|mimes:jpg,png,svg,jpeg,webp',
            'currency_code'         => 'required|string|max:10',
        ]);

        $validator->after(function ($validator) use ($gateway_name,$gateway) {
            // Search Gateway is unique or not
            if(PaymentGateway::whereNot(function($query) use ($gateway) {
                $query->where('id',$gateway->id);
            })->where(function($query) use ($gateway_name){
                $alias = Str::slug($gateway_name);
                $query->where('slug',PaymentGatewayConst::add_money_slug())
                ->where('type',PaymentGatewayConst::MANUAL)
                ->where('alias',$alias);
            })->exists()) {
                $validator->errors()->add(
                    'gateway_name', 'The gateway name has already been taken.'
                );
            }
        });

        $validated = $validator->validate();

        $validated['alias']                 = Str::slug($validated['gateway_name']);
        $validated['name']                  = $validated['gateway_name'];
        $validated['title']                 = $validated['name'] . " " . "Gateway";
        $validated['last_edit_by']          = Auth::user()->id;
        $validated['supported_currencies']  = [$validated['currency_code']];

        $validated['input_fields']          = decorate_input_fields($validated);
        $validated = Arr::except($validated,['gateway_name','label','input_type','min_char','max_char','field_necessity','file_extensions','file_max_size']);

        // validation payment gateway currencies
        $currency_validator = Validator::make($request->all(),[
            'min_limit'         => 'required|numeric',
            'max_limit'         => 'required|numeric',
            'fixed_charge'      => 'required|numeric',
            'percent_charge'    => 'required|numeric',
            'rate'              => 'required|numeric',
            'currency_code'     => 'required|string|max:10',
            'currency_symbol'   => 'nullable|string|max:10',

        ]);

        $currency_validated = $currency_validator->validate();
        $currency_validated['name'] = $validated['name'] . " " . $currency_validated['currency_code'];
        $currency_validated['alias'] = Str::slug($currency_validated['name'] . " " . PaymentGatewayConst::MANUAL);

        // uplaod image if have
        if($request->hasFile('image')) {
            try{
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_dynamic($image,'payment-gateways',$gateway->image);
                $validated['image'] = $upload_image;
            }catch(Exception $e) {
                return back()->with(['error' => ['Image upload faild! Please try again.']]);
            }
        }

        // Update Manual Payment Gateway Information
        try{
            $gateway->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        // Update Gateway Currency Information
        try{
            $gateway->currencies->first()->update($currency_validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway added successfully!']]);

    }

    /**
     * Function for Create Add New Manual Payment Gateway Page for Money Out
     * @return view
     */
    public function manualMoneyOutCreate() {
        $page_title = "Money Out Add";
        return view('admin.sections.payment-gateways.money-out.manual.create',compact(
            'page_title',
        ));
    }

    /**
     * Function for Store New Manual Payment Gateway for Money Out
     * @param  \Illuminate\Http\Request  $request
     */
    public function manualMoneyOutStore(Request $request) {

        $gateway_name = $request->gateway_name;
        $validator = Validator::make($request->all(),[
            'gateway_name'          => ['required','string','max:60',Rule::unique('payment_gateways','alias')->where(function($query) use ($gateway_name) {
                $alias = Str::slug($gateway_name);
                $query->where('slug',PaymentGatewayConst::money_out_slug())->where('type',PaymentGatewayConst::MANUAL)->where('alias',$alias);
            })],
            'desc'                  => 'nullable|string|max:10000',
            'label'                 => 'nullable|array',
            'label.*'               => 'nullable|string|max:50',
            'input_type'            => 'nullable|array',
            'input_type.*'          => 'nullable|string|max:20',
            'min_char'              => 'nullable|array',
            'min_char.*'            => 'nullable|numeric',
            'max_char'              => 'nullable|array',
            'max_char.*'            => 'nullable|numeric',
            'field_necessity'       => 'nullable|array',
            'field_necessity.*'     => 'nullable|string|max:20',
            'file_extensions'       => 'nullable|array',
            'file_extensions.*'     => 'nullable|string|max:255',
            'file_max_size'         => 'nullable|array',
            'file_max_size.*'       => 'nullable|numeric',
            'image'                 => 'nullable|image|mimes:jpg,png,svg,jpeg,webp',
            'currency_code'         => 'required|string|max:10',
        ]);

        $validator->after(function ($validator) use ($gateway_name) {
            // Search Gateway is unique or not
            if(PaymentGateway::moneyOut()->manual()->gateway(Str::slug($gateway_name))->exists()) {
                $validator->errors()->add(
                    'gateway_name', 'The gateway name has already been taken.'
                );
            }
        });

        $validated = $validator->validate();

        $validated['alias']                 = Str::slug($validated['gateway_name']);
        $validated['name']                  = $validated['gateway_name'];
        $validated['slug']                  = Str::slug(PaymentGatewayConst::MONEYOUT);
        $validated['title']                 = $validated['name'] . " " . "Gateway";
        $validated['type']                  = PaymentGatewayConst::MANUAL;
        $validated['last_edit_by']          = Auth::user()->id;
        $validated['supported_currencies']  = [$validated['currency_code']];

        $last_record_of_max_code = PaymentGateway::max('code') ?? 100;
        $validated['code']  = set_payment_gateway_code($last_record_of_max_code);

        $validated['input_fields']      = decorate_input_fields($validated);

        $validated = Arr::except($validated,['gateway_name','label','input_type','min_char','max_char','field_necessity','file_extensions','file_max_size','currency_code']);

        // validation payment gateway currencies
        $currency_validator = Validator::make($request->all(),[
            'min_limit'         => 'required|numeric',
            'max_limit'         => 'required|numeric',
            'fixed_charge'      => 'required|numeric',
            'percent_charge'    => 'required|numeric',
            'rate'              => 'required|numeric',
            'currency_code'     => 'required|string|max:10',
            'currency_symbol'   => 'nullable|string|max:10',

        ]);

        $currency_validated = $currency_validator->validate();
        $currency_validated['name'] = $validated['name'] . " " . $currency_validated['currency_code'];
        $currency_validated['alias'] = Str::slug($currency_validated['name'] . " " . PaymentGatewayConst::money_out_slug());

        // uplaod image if have
        if($request->hasFile('image')) {
            try{
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_dynamic($image,'payment-gateways');
                $validated['image'] = $upload_image;
            }catch(Exception $e) {
                return back()->with(['error' => ['Image upload faild! Please try again.']]);
            }
        }

        // Insert new manual payment gateway
        try{
            $validated['input_fields']  = json_encode($validated['input_fields']);
            $validated['supported_currencies'] = json_encode($validated['supported_currencies']);
            $payment_gateway_id = PaymentGateway::insertGetId($validated);
            $currency_validated['payment_gateway_id'] = $payment_gateway_id;
        }catch(Exception $e) {

            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        // insert gateway currency
        try{
            PaymentGatewayCurrency::create($currency_validated);
        }catch(Exception $e) {
            // if fails delete the payment gateway that added lastly
            PaymentGateway::find($payment_gateway_id)->delete();
            // Delete payment gateway image
            $image_link = $validated['image'] ?? null;
            if($image_link) {
                $image_link = get_files_path('payment-gateways') . "/" . $validated['image'];
                delete_file($image_link);
            }

            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway added successfully!']]);
    }


    /**
     * Function for Update Manual Money Out Payment Gateway Information Based On Alias
     * @param  \Illuminate\Http\Request  $request
     * @param string $alias
     */
    public function manualMoneyOutUpdate(Request $request,$alias) {
        // Find gateway is available or not
        $gateway = PaymentGateway::moneyOut()->manual()->gateway($alias)->first();
        if(!$gateway) {
            return back()->with(['error' => ['Opps! Payment gateway not found!']]);
        }
        // Validate Data
        $gateway_name = $request->gateway_name;
        $validator = Validator::make($request->all(),[
            'gateway_name'          => ['required','string','max:60',Rule::unique('payment_gateways','alias')->where(function($query) use ($gateway_name, $gateway) {
                $alias = Str::slug($gateway_name);
                $query->whereNot('id',$gateway->id)->where('slug',PaymentGatewayConst::money_out_slug())->where('type',PaymentGatewayConst::MANUAL)->where('alias',$alias);
            })],
            'desc'                  => 'nullable|string|max:10000',
            'label'                 => 'nullable|array',
            'label.*'               => 'nullable|string|max:50',
            'input_type'            => 'nullable|array',
            'input_type.*'          => 'nullable|string|max:20',
            'min_char'              => 'nullable|array',
            'min_char.*'            => 'nullable|numeric',
            'max_char'              => 'nullable|array',
            'max_char.*'            => 'nullable|numeric',
            'field_necessity'       => 'nullable|array',
            'field_necessity.*'     => 'nullable|string|max:20',
            'file_extensions'       => 'nullable|array',
            'file_extensions.*'     => 'nullable|string|max:255',
            'file_max_size'         => 'nullable|array',
            'file_max_size.*'       => 'nullable|numeric',
            'image'                 => 'nullable|image|mimes:jpg,png,svg,jpeg,webp',
            'currency_code'         => 'required|string|max:10',
        ]);

        $validator->after(function ($validator) use ($gateway_name,$gateway) {
            // Search Gateway is unique or not
            if(PaymentGateway::whereNot(function($query) use ($gateway) {
                $query->where('id',$gateway->id);
            })->where(function($query) use ($gateway_name){
                $alias = Str::slug($gateway_name);
                $query->where('slug',PaymentGatewayConst::money_out_slug())
                ->where('type',PaymentGatewayConst::MANUAL)
                ->where('alias',$alias);
            })->exists()) {
                $validator->errors()->add(
                    'gateway_name', 'The gateway name has already been taken.'
                );
            }
        });

        $validated = $validator->validate();

        $validated['alias']                 = Str::slug($validated['gateway_name']);
        $validated['name']                  = $validated['gateway_name'];
        $validated['title']                 = $validated['name'] . " " . "Gateway";
        $validated['last_edit_by']          = Auth::user()->id;
        $validated['supported_currencies']  = [$validated['currency_code']];

        $validated['input_fields']          = decorate_input_fields($validated);
        $validated = Arr::except($validated,['gateway_name','label','input_type','min_char','max_char','field_necessity','file_extensions','file_max_size']);

        // validation payment gateway currencies
        $currency_validator = Validator::make($request->all(),[
            'min_limit'         => 'required|numeric',
            'max_limit'         => 'required|numeric',
            'fixed_charge'      => 'required|numeric',
            'percent_charge'    => 'required|numeric',
            'rate'              => 'required|numeric',
            'currency_code'     => 'required|string|max:10',
            'currency_symbol'   => 'nullable|string|max:10',

        ]);

        $currency_validated = $currency_validator->validate();
        $currency_validated['name'] = $validated['name'] . " " . $currency_validated['currency_code'];
        $currency_validated['alias'] = Str::slug($currency_validated['name'] . " " . PaymentGatewayConst::money_out_slug());

        // uplaod image if have
        if($request->hasFile('image')) {
            try{
                $image = get_files_from_fileholder($request,'image');
                $upload_image = upload_files_from_path_dynamic($image,'payment-gateways',$gateway->image);
                $validated['image'] = $upload_image;
            }catch(Exception $e) {
                return back()->with(['error' => ['Image upload faild! Please try again.']]);
            }
        }

        // Update Payment Gateway Information
        try{
            $gateway->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        // Update Gateway Currency Information
        try{
            $gateway->currencies->first()->update($currency_validated);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway added successfully!']]);
    }


    public function remove(Request $request) {
        $validated = Validator::make($request->all(),[
            'target'        => 'required|integer|exists:payment_gateways,id',
        ],[
            'target.exists'     => 'Selected payment gateway is invalid!',
        ])->validate();

        // Delete payment gateway currency
        try{
            $gateway = PaymentGateway::find($validated['target']);
            $gateway->currencies()->delete();
            $gateway->delete();

            // dd($gateway);
            if($gateway->image != null) {
                $image_link = get_files_path('payment-gateways') . "/" . $gateway->image;
                delete_file($image_link);
            }
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Payment gateway deleted successfully!']]);
    }
}
