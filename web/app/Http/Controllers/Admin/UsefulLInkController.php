<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use App\Models\Admin\Language;
use App\Models\Admin\SetupPage;
use App\Constants\LanguageConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsefulLInkController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = Language::whereNot('code',LanguageConst::NOT_REMOVABLE)->get();
    }

     /**
     * Mehtod for show campaign section page
     * @method GET
     * @return Illuminate\Http\Request Response
     */
    public function index() {
        $languages = $this->languages;
        $page_title = "Useful Links";
        $type = Str::slug(GlobalConst::USEFUL_LINKS);
        $data = SetupPage::orderBy('id')->where('type', $type)->paginate(12);

        return view('admin.sections.setup-pages.useful-links.index',compact(
            'page_title',
            'languages',
            'data',
        ));
    }


    /**
     * Mehtod for show campaign section page
     * @method POST
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */

    public function store(Request $request){
        $title = ['title' => 'required|string|max:100'];
        $details = ['details' => 'required|string'];

        $type = Str::slug(GlobalConst::USEFUL_LINKS);

        $title_data['language']  = $this->contentValidate($request,$title);
        $details_data['language']  = $this->contentValidate($request,$details);


        $data['title']        = $title_data;
        $data['type']         = $type;
        $data['details']      = $details_data;
        $data['slug']         = Str::slug($title_data['language']['en']['title']);
        $data['last_edit_by'] = Auth::id();

        try {
            SetupPage::create($data);
        } catch (\Throwable $th) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Page added successfully!']]);
    }

    /**
     * Mehtod for show campaign section page
     * @method GET
     * @return Illuminate\Http\Request Response
     */
    public function edit($id) {
        $languages = $this->languages;
        $page_title = "Useful Link Edit";
        $data = SetupPage::findOrFail($id);
        return view('admin.sections.setup-pages.useful-links.edit',compact(
            'page_title',
            'languages',
            'data',
        ));
    }

    /**
     * Mehtod for show campaign section page
     * @method POST
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */

    public function update(Request $request){

        $validator = Validator::make($request->all(),[
            'target'        => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','useful-link-edit');
        }

        $validated = $validator->validated();

        $title = ['title' => 'required|string|max:100'];
        $details = ['details' => 'required|string'];

        $title_data['language']  = $this->contentValidate($request,$title);
        $details_data['language']  = $this->contentValidate($request,$details);


        $data['title']        = $title_data;
        $data['details']      = $details_data;
        $data['slug']         = Str::slug($title_data['language']['en']['title']);
        $data['last_edit_by'] = Auth::id();

        $setup_page = SetupPage::findOrFail($validated['target']);

        try {
            $setup_page->update($data);
        } catch (\Throwable $th) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->route('admin.useful.links.index')->with(['success' => ['Page updated successfully!']]);
    }

    /**
     * Mehtod for status update
     * @method PUT
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request  Response
     */
    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->safe()->all();
        $id = $validated['data_target'];

        $setup_page = SetupPage::findOrFail($id);

        if(!$setup_page) {
            $error = ['error' => ['Page record not found in our system.']];
            return Response::error($error,null,404);
        }


        try{
            $setup_page->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Page status updated successfully!']];

        return Response::success($success,null,200);
    }

    /**
     * Mehtod for status update
     * @method PUT
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request  Response
     */
    public function delete(Request $request) {
        $request->validate([
            'target'    => 'required|string',
        ]);

        $setup_page = SetupPage::findOrFail($request->target);

        try{
            $setup_page->delete();
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Page deleted successfully!']]);
    }


    /**
     * Method for get languages form record with little modification for using only this class
     * @return array $languages
     */
    public function languages() {
        $languages = Language::whereNot('code',LanguageConst::NOT_REMOVABLE)->select("code","name")->get()->toArray();
        $languages[] = [
            'name'      => LanguageConst::NOT_REMOVABLE_CODE,
            'code'      => LanguageConst::NOT_REMOVABLE,
        ];
        return $languages;
    }

    /**
     * Method for validate request data and re-decorate language wise data
     * @param object $request
     * @param array $basic_field_name
     * @return array $language_wise_data
     */
    public function contentValidate($request,$basic_field_name,$modal = null) {
        $languages = $this->languages();

        $current_local = get_default_language_code();
        $validation_rules = [];
        $language_wise_data = [];
        foreach($request->all() as $input_name => $input_value) {
            foreach($languages as $language) {
                $input_name_check = explode("_",$input_name);
                $input_lang_code = array_shift($input_name_check);
                $input_name_check = implode("_",$input_name_check);
                if($input_lang_code == $language['code']) {
                    if(array_key_exists($input_name_check,$basic_field_name)) {
                        $langCode = $language['code'];
                        if($current_local == $langCode) {
                            $validation_rules[$input_name] = $basic_field_name[$input_name_check];
                        }else {
                            $validation_rules[$input_name] = str_replace("required","nullable",$basic_field_name[$input_name_check]);
                        }
                        $language_wise_data[$langCode][$input_name_check] = $input_value;
                    }
                    break;
                }
            }
        }
        if($modal == null) {
            $validated = Validator::make($request->all(),$validation_rules)->validate();
        }else {
            $validator = Validator::make($request->all(),$validation_rules);
            if($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("modal",$modal);
            }
            $validated = $validator->validate();
        }

        return $language_wise_data;
    }
}
