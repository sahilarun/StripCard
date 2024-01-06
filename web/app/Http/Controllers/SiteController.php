<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\Language;
use App\Models\Admin\SetupPage;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function home(){
        $basic_settings = BasicSettings::first();
        $page_title = $basic_settings->site_title??"Home";

        return view('frontend.index',compact('page_title'));
    }

    public function about(){
        $page_title = "About";
        return view('frontend.about',compact('page_title'));
    }
    public function services(){
        $page_title = "Services";
        return view('frontend.services',compact('page_title'));
    }
    public function blog(){
        $page_title = "Announcements";
        $categories = BlogCategory::active()->latest()->get();
        $blogs = Blog::active()->orderBy('id',"DESC")->paginate(8);
        $recentPost = Blog::active()->latest()->limit(3)->get();
        return view('frontend.blogs',compact('page_title','blogs','recentPost','categories'));
    }
    public function blogDetails($id,$slug){
        $page_title = "Announcement Details";
        $categories = BlogCategory::active()->latest()->get();
        $blog = Blog::where('id',$id)->where('slug',$slug)->first();
        $recentPost = Blog::active()->where('id',"!=",$id)->latest()->limit(3)->get();
        return view('frontend.blogDetails',compact('page_title','blog','recentPost','categories'));
    }
    public function blogByCategory($id,$slug){
        $categories = BlogCategory::active()->latest()->get();
        $category = BlogCategory::findOrfail($id);
        $page_title = 'Category -'.' '. $category->name;
        $blogs = Blog::active()->where('category_id',$category->id)->latest()->paginate(8);
        $recentPost = Blog::active()->latest()->limit(3)->get();
        return view('frontend.blogByCategory',compact('page_title','blogs','category','categories','recentPost'));
    }
    public function contact(){
        $page_title = "Contact";
        return view('frontend.contact',compact('page_title'));
    }
    public function contactStore(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'name'    => 'required|string',
                'email'   => 'required|email',
                'mobile'  => 'required',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            if($validator->stopOnFirstFailure()->fails()){
                $error = ['errors' => $validator->errors()];
                return Response::error($error, null, 500);
            }

            $validated = $validator->safe()->all();

            try {
                Contact::create($validated);
            } catch (\Exception $th) {
                $error = ['error' => 'Something went worng!. Please try again.'];
                return Response::error($error, null, 500);
            }

            $success = ['success' => ['Your message submited!']];
            return Response::success($success,null,200);
        }
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }
    public function usefulPage($slug){
        $defualt = selectedLang();

        $page = SetupPage::where('slug', $slug)->where('status', 1)->first();

        if(empty($page)){
            abort(404);
        }
        $page_title = $page->title->language->$defualt->title;

        return view('frontend.policy_pages',compact('page_title','page','defualt'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json('Cookie allow successfully');
    }
    public function cookieDecline(){
        session()->put('cookie_decline',true);
        return response()->json('Cookie decline successfully');
    }


}
