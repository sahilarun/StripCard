<?php

namespace App\Http\Controllers\Admin;

use App\Constants\LanguageConst;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Models\Admin\Language;
use App\Models\Admin\SiteSections;
use App\Models\Blog;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SetupSectionsController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = Language::whereNot('code',LanguageConst::NOT_REMOVABLE)->get();
    }

    /**
     * Register Sections with their slug
     * @param string $slug
     * @param string $type
     * @return string
     */
    public function section($slug,$type) {
        $sections = [
            'home_banner'    => [
                'view'      => "bannerView",
                'update'    => "bannerUpdate",
            ],
            'start-section'    => [
                'view'      => "startSectionView",
                'update'    => "startSectionUpdate",
            ],
            'about_section'  => [
                'view'      => "aboutView",
                'update'    => "aboutUpdate",
                'itemStore'     => "aboutItemStore",
                'itemUpdate'    => "aboutItemUpdate",
                'itemDelete'    => "aboutItemDelete",
            ],
            'our-feature'  => [
                'view'      => "ourFeatureView",
                'update'    => "ourFeatureUpdate",
                'itemStore'     => "ourFeatureItemStore",
                'itemUpdate'    => "ourFeatureItemUpdate",
                'itemDelete'    => "ourFeatureItemDelete",
            ],
            'work-section'  => [
                'view'      => "workView",
                'update'    => "workUpdate",
                'itemStore'     => "workItemStore",
                'itemUpdate'    => "workItemUpdate",
                'itemDelete'    => "workItemDelete",
            ],
            'statistics-section'  => [
                'view'      => "statisticsView",
                'update'    => "statisticsUpdate"
            ],
            'service-section'  => [
                'view'      => "serviceView",
                'update'    => "serviceUpdate",
                'itemStore'     => "serviceItemStore",
                'itemUpdate'    => "serviceItemUpdate",
                'itemDelete'    => "serviceItemDelete",
            ],
            'testimonials-section'  => [
                'view'      => "testimonialView",
                'update'    => "testimonialUpdate",
                'itemStore'     => "testimonialItemStore",
                'itemUpdate'    => "testimonialItemUpdate",
                'itemDelete'    => "testimonialItemDelete",
            ],
             'contact'    => [
                'view'      => "contactView",
                'update'    => "contactUpdate",
            ],
            'footer-section'  => [
                'view'      => "footerView",
                'update'    => "footerUpdate",
                'itemStore'     => "footerItemStore",
                'itemUpdate'    => "footerItemUpdate",
                'itemDelete'    => "footerItemDelete",
            ],
            'category'    => [
                'view'      => "categoryView",
            ],
            'blog-section'    => [
                'view'      => "blogView",
                'update'    => "blogUpdate",
            ],

        ];

        if(!array_key_exists($slug,$sections)) abort(404);
        if(!isset($sections[$slug][$type])) abort(404);
        $next_step = $sections[$slug][$type];
        return $next_step;
    }

    /**
     * Method for getting specific step based on incomming request
     * @param string $slug
     * @return method
     */
    public function sectionView($slug) {
        $section = $this->section($slug,'view');
        return $this->$section($slug);
    }

    /**
     * Method for distribute store method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemStore(Request $request, $slug) {
        $section = $this->section($slug,'itemStore');
        return $this->$section($request,$slug);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemUpdate(Request $request, $slug) {
        $section = $this->section($slug,'itemUpdate');
        return $this->$section($request,$slug);
    }

    /**
     * Method for distribute delete method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemDelete(Request $request,$slug) {
        $section = $this->section($slug,'itemDelete');
        return $this->$section($request,$slug);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionUpdate(Request $request,$slug) {
        $section = $this->section($slug,'update');
        return $this->$section($request,$slug);
    }

    public function bannerView($slug) {
        $page_title = "Home Banner Section";
        $section_slug = Str::slug(SiteSectionConst::HOME_BANNER);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.home-banner',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function bannerUpdate(Request $request,$slug) {
        $basic_field_name = ['heading' => "required|string|max:100",'sub_heading' => "required|string|max:255",'button_name' => "required|string|max:50",'button_link' => "required|string|max:255"];

        $slug = Str::slug(SiteSectionConst::HOME_BANNER);
        $section = SiteSections::where("key",$slug)->first();


        $data['images']['banner_image'] = $section->value->images->banner_image ?? "";
        if($request->hasFile("banner_image")) {
            $data['images']['banner_image']      = $this->imageValidate($request,"banner_image",$section->value->images->banner_image ?? null);
        }



        $data['language']  = $this->contentValidate($request,$basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;


        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //==========================start sections=====================
    public function startSectionView($slug) {
        $page_title = "Start Section";
        $section_slug = Str::slug(SiteSectionConst::START_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.start-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function startSectionUpdate(Request $request,$slug) {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'button_name' => "required|string|max:50",
            'button_link' => "required|string|max:255"];

        $slug = Str::slug(SiteSectionConst::START_SECTION);
        $section = SiteSections::where("key",$slug)->first();


        $data['images']['image'] = $section->value->images->image ?? "";
        if($request->hasFile("image")) {
            $data['images']['image']     = $this->imageValidate($request,"image",$section->value->images->image ?? null);
        }
        $data['language']  = $this->contentValidate($request,$basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    //=======================End Start Section=======================
    //=======================About Section start=======================

    public function aboutView($slug) {
        $page_title = "About Section";
        $section_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.about-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function aboutUpdate(Request $request,$slug) {
        $basic_field_name = [
            'section_title' => "required|string|max:100",
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::where("key",$slug)->first();
        if($section != null) {
            $data = json_decode(json_encode($section->value),true);
        }else {
            $data = [];
        }
        $data['images']['image'] = $section->value->images->image ?? "";
        if($request->hasFile("image")) {
            $data['images']['image']      = $this->imageValidate($request,"image",$section->value->images->image ?? null);
        }

        $data['language']  = $this->contentValidate($request,$basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    public function aboutItemStore(Request $request,$slug) {
        $basic_field_name = [
            'title'     => "required|string|max:255",
            'icon'     => "required|string|max:255",
        ];

        $language_wise_data = $this->contentValidate($request,$basic_field_name,"about-add");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::where("key",$slug)->first();

        if($section != null) {
            $section_data = json_decode(json_encode($section->value),true);
        }else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['About item added successfully!']]);
    }

    public function aboutItemUpdate(Request $request,$slug) {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'title_edit'     => "required|string|max:255",
            'icon_edit'     => "required|string|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);


        $language_wise_data = $this->contentValidate($request,$basic_field_name,"about-edit");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function($language) {
            return replace_array_key($language,"_edit");
        },$language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;
        try{
            $section->update([
                'value' => $section_values,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }


    public function aboutItemDelete(Request $request,$slug) {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);
        try{
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        }catch(Exception $e) {
            return  $e->getMessage();
        }

        return back()->with(['success' => ['About item delete successfully!']]);
    }
    //=======================About  Section End===================================
    //======================Our Features section Start ===============================
    public function ourFeatureView($slug) {
        $page_title = "Our Features Section";
        $section_slug = Str::slug(SiteSectionConst::OUR_FEATURE);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.our-feature-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function ourFeatureUpdate(Request $request,$slug) {
        $basic_field_name = [
            'heading' => "required|string|max:100",
            'sub_heading' => "required|string|max:200",
            'details' => "required|string",

        ];

        $slug = Str::slug(SiteSectionConst::OUR_FEATURE);
        $section = SiteSections::where("key",$slug)->first();
        if($section != null) {
            $data = json_decode(json_encode($section->value),true);
        }else {
            $data = [];
        }

        $data['language']  = $this->contentValidate($request,$basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    public function  ourFeatureItemStore(Request $request,$slug) {
        $basic_field_name = [
            'title'     => "required|string|max:100",
            'sub_title'     => "required|string",
        ];

        $language_wise_data = $this->contentValidate($request,$basic_field_name,"feature-add");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::OUR_FEATURE);
        $section = SiteSections::where("key",$slug)->first();

        if($section != null) {
            $section_data = json_decode(json_encode($section->value),true);
        }else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Item added successfully!']]);
    }


    public function  ourFeatureItemUpdate(Request $request,$slug) {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'title_edit'     => "required|string|max:100",
            'sub_title_edit'     => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::OUR_FEATURE);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);


        $language_wise_data = $this->contentValidate($request,$basic_field_name,"feature-edit");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function($language) {
            return replace_array_key($language,"_edit");
        },$language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;
        try{
            $section->update([
                'value' => $section_values,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    public function  ourFeatureItemDelete(Request $request,$slug) {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::OUR_FEATURE);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);
        try{
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        }catch(Exception $e) {
            return  $e->getMessage();
        }

        return back()->with(['success' => ['Item delete successfully!']]);
    }
//=======================Our Features  Section End===================================
//=======================Work section Start ==================================
    public function workView($slug) {
        $page_title = "Works Section";
        $section_slug = Str::slug(SiteSectionConst::WORK_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.work-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function workUpdate(Request $request,$slug) {
        $basic_field_name = [
            'title' => "required|string|max:50",
            'sub_title' => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::WORK_SECTION);
        $section = SiteSections::where("key",$slug)->first();
        if($section != null) {
            $data = json_decode(json_encode($section->value),true);
        }else {
            $data = [];
        }

        $data['language']  = $this->contentValidate($request,$basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

    public function workItemStore(Request $request,$slug) {
        $basic_field_name = [
            'name'     => "required|string|max:100",
            'icon'     => "required|string|max:100",
            'details'     => "required|string",
        ];

        $language_wise_data = $this->contentValidate($request,$basic_field_name,"work-add");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::WORK_SECTION);
        $section = SiteSections::where("key",$slug)->first();

        if($section != null) {
            $section_data = json_decode(json_encode($section->value),true);
        }else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Item added successfully!']]);
    }
    public function workItemUpdate(Request $request,$slug) {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'name_edit'     => "required|string|max:100",
            'icon_edit'     => "required|string|max:100",
            'details_edit'     => "required|string"
        ];

        $slug = Str::slug(SiteSectionConst::WORK_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);


        $language_wise_data = $this->contentValidate($request,$basic_field_name,"work-edit");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function($language) {
            return replace_array_key($language,"_edit");
        },$language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;
        try{
            $section->update([
                'value' => $section_values,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    public function workItemDelete(Request $request,$slug) {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::WORK_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);
        try{
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        }catch(Exception $e) {
            return  $e->getMessage();
        }

        return back()->with(['success' => ['Item delete successfully!']]);
    }
//=======================Work  Section End===================================
//=======================Statistics  Section Start===================================
    public function statisticsView($slug) {
        $page_title = "Statistics Section";
        $section_slug = Str::slug(SiteSectionConst::STATISTICS_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.statistics-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }

    public function  statisticsUpdate(Request $request,$slug) {
        $basic_field_name = [
            'total_users' => "required|string|max:50",
            'happy_users' => "required|string",
            'total_service' => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::STATISTICS_SECTION);
        $section = SiteSections::where("key",$slug)->first();
        if($section != null) {
            $data = json_decode(json_encode($section->value),true);
        }else {
            $data = [];
        }

        $data['language']  = $this->contentValidate($request,$basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }

//=======================Statistics  Section End===================================
//======================Service section Start ===============================
public function serviceView($slug) {
    $page_title = "Service Section";
    $section_slug = Str::slug(SiteSectionConst::SERVICE_SECTION);
    $data = SiteSections::getData($section_slug)->first();
    $languages = $this->languages;

    return view('admin.sections.setup-sections.service-section',compact(
        'page_title',
        'data',
        'languages',
        'slug',
    ));
}

public function serviceUpdate(Request $request,$slug) {
    $basic_field_name = [
        'heading' => "required|string|max:100",
        'sub_heading' => "required|string|max:200",

    ];

    $slug = Str::slug(SiteSectionConst::SERVICE_SECTION);
    $section = SiteSections::where("key",$slug)->first();
    if($section != null) {
        $data = json_decode(json_encode($section->value),true);
    }else {
        $data = [];
    }

    $data['language']  = $this->contentValidate($request,$basic_field_name);

    $update_data['key']    = $slug;
    $update_data['value']  = $data;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Section updated successfully!']]);
}

public function serviceItemStore(Request $request,$slug) {
    $basic_field_name = [
        'title'     => "required|string|max:100",
        'sub_title'     => "required|string",
    ];

    $language_wise_data = $this->contentValidate($request,$basic_field_name,"service-add");
    if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
    $slug = Str::slug(SiteSectionConst::SERVICE_SECTION);
    $section = SiteSections::where("key",$slug)->first();

    if($section != null) {
        $section_data = json_decode(json_encode($section->value),true);
    }else {
        $section_data = [];
    }
    $unique_id = uniqid();

    $section_data['items'][$unique_id]['language'] = $language_wise_data;
    $section_data['items'][$unique_id]['id'] = $unique_id;
    $section_data['items'][$unique_id]['image'] = "";

    if($request->hasFile("image")) {
        $section_data['items'][$unique_id]['image'] = $this->imageValidate($request,"image",$section->value->items->image ?? null);
    }

    $update_data['key'] = $slug;
    $update_data['value']   = $section_data;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Section item added successfully!']]);
}


public function serviceItemUpdate(Request $request,$slug) {
    $request->validate([
        'target'    => "required|string",
    ]);

    $basic_field_name = [
        'title_edit'     => "required|string|max:100",
        'sub_title_edit'     => "required|string",
    ];
    $slug = Str::slug(SiteSectionConst::SERVICE_SECTION);
    $section = SiteSections::getData($slug)->first();
    if(!$section) return back()->with(['error' => ['Section not found!']]);
    $section_values = json_decode(json_encode($section->value),true);
    if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
    if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

    $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);
    $language_wise_data = $this->contentValidate($request,$basic_field_name,"service-edit");
    if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

    $language_wise_data = array_map(function($language) {
        return replace_array_key($language,"_edit");
    },$language_wise_data);

    $section_values['items'][$request->target]['language'] = $language_wise_data;

    if($request->hasFile("image")) {
        $section_values['items'][$request->target]['image']    = $this->imageValidate($request,"image",$section_values['items'][$request->target]['image'] ?? null);
    }

    try{
        $section->update([
            'value' => $section_values,
        ]);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Information updated successfully!']]);
}

public function serviceItemDelete(Request $request,$slug) {
    $request->validate([
        'target'    => 'required|string',
    ]);
    $slug = Str::slug(SiteSectionConst::SERVICE_SECTION);
    $section = SiteSections::getData($slug)->first();
    if(!$section) return back()->with(['error' => ['Section not found!']]);
    $section_values = json_decode(json_encode($section->value),true);
    if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
    if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);
    try{
        unset($section_values['items'][$request->target]);
        $section->update([
            'value'     => $section_values,
        ]);
    }catch(Exception $e) {
        return  $e->getMessage();
    }

    return back()->with(['success' => ['Service item delete successfully!']]);
}
//=======================Service  Section End===================================
//=======================testimonial Section End===============================

public function testimonialView($slug) {
    $page_title = "Testimonial Section";
    $section_slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
    $data = SiteSections::getData($section_slug)->first();
    $languages = $this->languages;

    return view('admin.sections.setup-sections.testimonial-section',compact(
        'page_title',
        'data',
        'languages',
        'slug',
    ));
}
public function testimonialUpdate(Request $request,$slug) {
    $basic_field_name = [
        'title' => "required|string|max:50",
        'sub_heading' => "required|string",
    ];

    $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
    $section = SiteSections::where("key",$slug)->first();
    if($section != null) {
        $data = json_decode(json_encode($section->value),true);
    }else {
        $data = [];
    }
    $data['language']  = $this->contentValidate($request,$basic_field_name);

    $update_data['key']    = $slug;
    $update_data['value']  = $data;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Section updated successfully!']]);
}
public function testimonialItemStore(Request $request,$slug) {
    $basic_field_name = [
        'name'     => "required|string|max:100",
        'designation'     => "required|string|max:100",
        'rating'     => "required|string|max:100",
        'details'   => "required|string",
    ];

    $language_wise_data = $this->contentValidate($request,$basic_field_name,"testimonial-add");
    if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
    $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
    $section = SiteSections::where("key",$slug)->first();

    if($section != null) {
        $section_data = json_decode(json_encode($section->value),true);
    }else {
        $section_data = [];
    }
    $unique_id = uniqid();

    $section_data['items'][$unique_id]['language'] = $language_wise_data;
    $section_data['items'][$unique_id]['id'] = $unique_id;
    $section_data['items'][$unique_id]['image'] = "";

    if($request->hasFile("image")) {
        $section_data['items'][$unique_id]['image'] = $this->imageValidate($request,"image",$section->value->items->image ?? null);
    }

    $update_data['key'] = $slug;
    $update_data['value']   = $section_data;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Section item added successfully!']]);
}
public function testimonialItemUpdate(Request $request,$slug) {

    $request->validate([
        'target'    => "required|string",
    ]);

    $basic_field_name = [
        'name_edit'     => "required|string|max:100",
        'designation_edit'     => "required|string|max:100",
        'rating_edit'     => "required|string|max:100",
        'details_edit'   => "required|string",
    ];

    $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
    $section = SiteSections::getData($slug)->first();
    if(!$section) return back()->with(['error' => ['Section not found!']]);
    $section_values = json_decode(json_encode($section->value),true);
    if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
    if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

    $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

    $language_wise_data = $this->contentValidate($request,$basic_field_name,"testimonial-edit");
    if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

    $language_wise_data = array_map(function($language) {
        return replace_array_key($language,"_edit");
    },$language_wise_data);

    $section_values['items'][$request->target]['language'] = $language_wise_data;

    if($request->hasFile("image")) {
        $section_values['items'][$request->target]['image']    = $this->imageValidate($request,"image",$section_values['items'][$request->target]['image'] ?? null);
    }

    try{
        $section->update([
            'value' => $section_values,
        ]);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Information updated successfully!']]);
}
public function testimonialItemDelete(Request $request,$slug) {
    $request->validate([
        'target'    => 'required|string',
    ]);
    $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
    $section = SiteSections::getData($slug)->first();
    if(!$section) return back()->with(['error' => ['Section not found!']]);
    $section_values = json_decode(json_encode($section->value),true);
    if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
    if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

    try{
        $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
        unset($section_values['items'][$request->target]);
        delete_file($image_link);
        $section->update([
            'value'     => $section_values,
        ]);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Section item delete successfully!']]);
}

//=======================testimonial Section End===============================
public function contactView($slug) {
    $page_title = "Contact Section";
    $section_slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
    $data = SiteSections::getData($section_slug)->first();
    $languages = $this->languages;

    return view('admin.sections.setup-sections.contact-section',compact(
        'page_title',
        'data',
        'languages',
        'slug',
    ));
}
public function contactUpdate(Request $request,$slug) {
    $basic_field_name = [
        'title' => "required|string|max:100",
        'heading' => "required|string|max:100",
        'infomation'  => "required|string",
        'address'  => "required|string",
        'phone'  => "required|string",
        'email'  => "required|string|max:100",

    ];

    $slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
    $section = SiteSections::where("key",$slug)->first();
    $data['language']  = $this->contentValidate($request,$basic_field_name);
    $update_data['key']    = $slug;
    $update_data['value']  = $data;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Section updated successfully!']]);
}
//=======================contact App Section End==============================

    //=======================footer Section End===============================

    public function  footerView($slug) {
        $page_title = "Footer Section";
        $section_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $data = SiteSections::getData($section_slug)->first();

        $languages = $this->languages;

        return view('admin.sections.setup-sections.footer-section',compact(
            'page_title',
            'data',
            'languages',
            'slug',
        ));
    }
    public function  footerUpdate(Request $request,$slug) {
        $basic_field_name = [
            'footer_text' => "required|string|max:100",
            'details' => "required|string",
        ];

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key",$slug)->first();
        if($section != null) {
            $data = json_decode(json_encode($section->value),true);
        }else {
            $data = [];
        }
        $data['language']  = $this->contentValidate($request,$basic_field_name);

        $update_data['key']    = $slug;
        $update_data['value']  = $data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section updated successfully!']]);
    }
    public function  footerItemStore(Request $request,$slug) {
        $basic_field_name = [
            'name'     => "required|string|max:100",
            'social_icon'   => "required|string|max:255",
            'link'   => "required|string|url|max:255",
        ];

        $language_wise_data = $this->contentValidate($request,$basic_field_name,"icon-add");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key",$slug)->first();

        if($section != null) {
            $section_data = json_decode(json_encode($section->value),true);
        }else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Section item added successfully!']]);
    }
    public function  footerItemUpdate(Request $request,$slug) {

        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'name_edit'     => "required|string|max:100",
            'social_icon_edit'   => "required|string|max:255",
            'link_edit'   => "required|string|url|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        $language_wise_data = $this->contentValidate($request,$basic_field_name,"icon-edit");
        if($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function($language) {
            return replace_array_key($language,"_edit");
        },$language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;
        try{
            $section->update([
                'value' => $section_values,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return back()->with(['success' => ['Information updated successfully!']]);
    }

    public function footerItemDelete(Request $request,$slug) {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if(!$section) return back()->with(['error' => ['Section not found!']]);
        $section_values = json_decode(json_encode($section->value),true);
        if(!isset($section_values['items'])) return back()->with(['error' => ['Section item not found!']]);
        if(!array_key_exists($request->target,$section_values['items'])) return back()->with(['error' => ['Section item is invalid!']]);

        try{
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Section item delete successfully!']]);
    }
    //=======================Category  Section Start=======================
public function categoryView(){
    $page_title = "Setup Blog Category";
    $allCategory = BlogCategory::orderByDesc('id')->paginate(10);
    return view('admin.sections.blog-category.index',compact(
        'page_title',
        'allCategory',
    ));
}
public function storeCategory(Request $request){

    $validator = Validator::make($request->all(),[
        'name'      => 'required|string|max:200|unique:blog_categories,name',
    ]);
    if($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('modal','category-add');
    }
    $validated = $validator->validate();
    $slugData = Str::slug($request->name);
    $makeUnique = BlogCategory::where('slug',  $slugData)->first();
    if($makeUnique){
        return back()->with(['error' => [ $request->name.' '.'Category Already Exists!']]);
    }
    $admin = Auth::user();

    $validated['admin_id']      = $admin->id;
    $validated['name']          = $request->name;
    $validated['slug']          = $slugData;
    try{
        BlogCategory::create($validated);
        return back()->with(['success' => ['Category Saved Successfully!']]);
    }catch(Exception $e) {
        return back()->withErrors($validator)->withInput()->with(['error' => ['Something went worng! Please try again.']]);
    }
}
public function categoryUpdate(Request $request){
    $target = $request->target;
    $category = BlogCategory::where('id',$target)->first();
    $validator = Validator::make($request->all(),[
        'name'      => 'required|string|max:200',
    ]);
    if($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('modal','edit-category');
    }
    $validated = $validator->validate();

    $slugData = Str::slug($request->name);
    $makeUnique = BlogCategory::where('id',"!=",$category->id)->where('slug',  $slugData)->first();
    if($makeUnique){
        return back()->with(['error' => [ $request->name.' '.'Category Already Exists!']]);
    }
    $admin = Auth::user();
    $validated['admin_id']      = $admin->id;
    $validated['name']          = $request->name;
    $validated['slug']          = $slugData;

    try{
        $category->fill($validated)->save();
        return back()->with(['success' => ['Category Updated Successfully!']]);
    }catch(Exception $e) {
        return back()->withErrors($validator)->withInput()->with(['error' => ['Something went worng! Please try again.']]);
    }
}
public function categoryStatusUpdate(Request $request) {
    $validator = Validator::make($request->all(),[
        'status'                    => 'required|boolean',
        'data_target'               => 'required|string',
    ]);
    if ($validator->stopOnFirstFailure()->fails()) {
        $error = ['error' => $validator->errors()];
        return Response::error($error,null,400);
    }
    $validated = $validator->safe()->all();
    $category_id = $validated['data_target'];

    $category = BlogCategory::where('id',$category_id)->first();
    if(!$category) {
        $error = ['error' => ['Category record not found in our system.']];
        return Response::error($error,null,404);
    }

    try{
        $category->update([
            'status' => ($validated['status'] == true) ? false : true,
        ]);
    }catch(Exception $e) {
        $error = ['error' => ['Something went worng!. Please try again.']];
        return Response::error($error,null,500);
    }

    $success = ['success' => ['Category status updated successfully!']];
    return Response::success($success,null,200);
}
public function categoryDelete(Request $request) {
    $validator = Validator::make($request->all(),[
        'target'        => 'required|string|exists:blog_categories,id',
    ]);
    $validated = $validator->validate();
    $category = BlogCategory::where("id",$validated['target'])->first();

    try{
        $category->delete();
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Category deleted successfully!']]);
}
public function categorySearch(Request $request) {
    $validator = Validator::make($request->all(),[
        'text'  => 'required|string',
    ]);

    if($validator->fails()) {
        $error = ['error' => $validator->errors()];
        return Response::error($error,null,400);
    }

    $validated = $validator->validate();

    $allCategory = BlogCategory::search($validated['text'])->select()->limit(10)->get();
    return view('admin.components.search.category-search',compact(
        'allCategory',
    ));
}
//=======================Category  Section End=======================
//=======================================Banner section Start =====================================
public function blogView($slug) {
    $page_title = "Blog Section";
    $section_slug = Str::slug(SiteSectionConst::BLOG_SECTION);
    $data = SiteSections::getData($section_slug)->first();
    $languages = $this->languages;
    $categories = BlogCategory::where('status',1)->latest()->get();
    $blogs = Blog::latest()->paginate(10);

    return view('admin.sections.setup-sections.blog-section',compact(
        'page_title',
        'data',
        'languages',
        'slug',
        'categories',
        'blogs'
    ));
}
public function blogUpdate(Request $request,$slug) {
    $basic_field_name = ['title' => "required|string|max:100",'heading' => "required|string|max:100"];

    $slug = Str::slug(SiteSectionConst::BLOG_SECTION);
    $section = SiteSections::where("key",$slug)->first();
    $data['language']  = $this->contentValidate($request,$basic_field_name);
    $update_data['value']  = $data;
    $update_data['key']    = $slug;

    try{
        SiteSections::updateOrCreate(['key' => $slug],$update_data);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['Section updated successfully!']]);
}
public function blogItemStore(Request $request){
    $validator = Validator::make($request->all(),[
        'category_id'      => 'required|integer',
        'en_name'     => "required|string",
        'en_details'     => "required|string",
        'tags'          => 'nullable|array',
        'tags.*'        => 'nullable|string|max:30',
        'image'         => 'required|image|mimes:png,jpg,jpeg,svg,webp',
    ]);


    $name_filed = [
        'name'     => "required|string",
    ];
    $details_filed = [
        'details'     => "required|string",
    ];

    if($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('modal','blog-add');
    }
    $validated = $validator->validate();

    // Multiple language data set
    $language_wise_name = $this->contentValidate($request,$name_filed);
    $language_wise_details = $this->contentValidate($request,$details_filed);

    $name_data['language'] = $language_wise_name;
    $details_data['language'] = $language_wise_details;

    $validated['category_id']        = $request->category_id;
    $validated['admin_id']        = Auth::user()->id;
    $validated['name']            = $name_data;
    $validated['details']           = $details_data;
    $validated['slug']            = Str::slug($name_data['language']['en']['name']);
    $validated['tag']           = $request->tags;
    $validated['created_at']      = now();


    // Check Image File is Available or not
    if($request->hasFile('image')) {
        $image = get_files_from_fileholder($request,'image');
        $upload = upload_files_from_path_dynamic($image,'blog');
        $validated['image'] = $upload;
    }

    try{
        Blog::create($validated);
    }catch(Exception $e) {

        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Blog item added successfully!']]);

}
public function blogEdit($id)
    {
        $page_title = "Blog Edit";
        $languages = $this->languages;
        $data = Blog::findOrFail($id);
        $categories = BlogCategory::where('status',1)->latest()->get();

        return view('admin.sections.setup-sections.blog-section-edit', compact(
            'page_title',
            'languages',
            'data',
            'categories',
        ));
    }
public function blogItemUpdate(Request $request) {


    $validator = Validator::make($request->all(),[
        'category_id'      => 'required|integer',
        'en_name'     => "required|string",
        'en_details'     => "required|string",
        'tags'          => 'nullable|array',
        'tags.*'        => 'nullable|string|max:30',
        'image'         => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
        'target'        => 'required|integer',
    ]);


    $name_filed = [
        'name'     => "required|string",
    ];
    $details_filed = [
        'details'     => "required|string",
    ];

    if($validator->fails()) {
        return back()->withErrors($validator)->withInput()->with('modal','blog-edit');
    }
    $validated = $validator->validate();
    $blog = Blog::findOrFail($validated['target']);

    // Multiple language data set
    $language_wise_name = $this->contentValidate($request,$name_filed);
    $language_wise_details = $this->contentValidate($request,$details_filed);

    $name_data['language'] = $language_wise_name;
    $details_data['language'] = $language_wise_details;

    $validated['category_id']        = $request->category_id;
    $validated['admin_id']        = Auth::user()->id;
    $validated['name']            = $name_data;
    $validated['details']           = $details_data;
    $validated['slug']            = Str::slug($name_data['language']['en']['name']);
    $validated['tag']           = $request->tags;
    $validated['created_at']      = now();

       // Check Image File is Available or not
       if($request->hasFile('image')) {

            $image = get_files_from_fileholder($request,'image');
            $upload = upload_files_from_path_dynamic($image,'blog',$blog->image);
            $validated['image'] = $upload;

        }

    try{
        $blog->update($validated);
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again']]);
    }

    return back()->with(['success' => ['Blog item updated successfully!']]);
}

public function blogItemDelete(Request $request) {
    $request->validate([
        'target'    => 'required|string',
    ]);

    $blog = Blog::findOrFail($request->target);

    try{
        $image_link = get_files_path('blog') . '/' . $blog->image;
        delete_file($image_link);
        $blog->delete();
    }catch(Exception $e) {
        return back()->with(['error' => ['Something went worng! Please try again.']]);
    }

    return back()->with(['success' => ['BLog delete successfully!']]);
}
public function blogStatusUpdate(Request $request) {
    $validator = Validator::make($request->all(),[
        'status'                    => 'required|boolean',
        'data_target'               => 'required|string',
    ]);
    if ($validator->stopOnFirstFailure()->fails()) {
        $error = ['error' => $validator->errors()];
        return Response::error($error,null,400);
    }
    $validated = $validator->safe()->all();
    $blog_id = $validated['data_target'];

    $blog = Blog::where('id',$blog_id)->first();
    if(!$blog) {
        $error = ['error' => ['Blog record not found in our system.']];
        return Response::error($error,null,404);
    }

    try{
        $blog->update([
            'status' => ($validated['status'] == true) ? false : true,
        ]);
    }catch(Exception $e) {
        $error = ['error' => ['Something went worng!. Please try again.']];
        return Response::error($error,null,500);
    }

    $success = ['success' => ['Blog status updated successfully!']];
    return Response::success($success,null,200);
}
//=======================================Banner section End ==========================================


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

    /**
     * Method for validate request image if have
     * @param object $request
     * @param string $input_name
     * @param string $old_image
     * @return boolean|string $upload
     */
    public function imageValidate($request,$input_name,$old_image) {
        if($request->hasFile($input_name)) {
            $image_validated = Validator::make($request->only($input_name),[
                $input_name         => "image|mimes:png,jpg,webp,jpeg,svg",
            ])->validate();

            $image = get_files_from_fileholder($request,$input_name);
            $upload = upload_files_from_path_dynamic($image,'site-section',$old_image);
            return $upload;
        }

        return false;
    }

}
