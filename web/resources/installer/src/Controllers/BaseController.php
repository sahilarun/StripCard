<?php

namespace Project\Installer\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Project\Installer\Helpers\DBHelper;
use Illuminate\Support\Facades\Validator;
use Project\Installer\Helpers\ErrorHelper;
use Project\Installer\Helpers\Helper;
use Project\Installer\Helpers\RequirementHelper;
use Project\Installer\Helpers\URLHelper;
use Project\Installer\Helpers\ValidationHelper;

class BaseController extends Controller {

    public function __construct()
    {
        if(!request()->routeIs('project.install.finish') && request()->routeIs('project.install.*')) {
            if(env("PURCHASE_CODE",'') != "") {
                return abort(404);
            }
        }else if(request()->routeIs('project.install.finish')) {
            if(DBHelper::step('admin_account' !== "PASSED")) {
                return abort(404);
            }
        }
    }

    public function welcomeView(Helper $helper) {
        cache()->driver('file')->forget($helper->cache_key);
        $page_title = "Installation - Welcome";
        return view('installer.pages.welcome',compact('page_title'));
    }

    public function installationProcessCancel() {
        $page_title = "Installation - Cancel";
        return view('installer.pages.cancel',compact('page_title'));
    }

    public function requirementsView(ErrorHelper $handleError, RequirementHelper $handleRequirements) {

        if($handleRequirements->requirementConfigIsInvalid()) {
            return $handleError->redirectErrorPage(['Failed to open installer configuration file!']);
        }

        $requirements = $handleRequirements->getRequirementStatus();
        // Get All status

        $page_title = "Installation - Requirements";
        return view('installer.pages.requirements',compact('page_title','requirements'));
    }

    public function purchaseValidationForm() {
        if(RequirementHelper::step() != "PASSED") {
            return redirect()->route('project.install.requirements');
        }

        $page_title = "Installation - Validation";
        return view('installer.pages.validation-form',compact('page_title'));
    }

    public function purchaseValidationFormSubmit(Request $request, ErrorHelper $handleError, ValidationHelper $validator) {

        $request->validate([
            'username'      => 'required|string',
            'code'          => 'required|string',
        ]);

        try{
            $validator->validate($request->all());
        }catch(Exception $e) {
            return $handleError->redirectErrorPage([$e->getMessage()]);
        }
        return redirect()->route('project.install.database.config');
    }

    public function databaseConfigView(Helper $helper) {
        $page_title = "Installation - Database Configuration";
        if(RequirementHelper::step() !== "PASSED") return redirect()->route('project.install.requirements');
        if(ValidationHelper::step() !== "PASSED") return redirect()->route('project.install.validation.form');

        $host_name = request()->host();
        if($host_name != "localhost" && $host_name != "127.0.0.1") {
            $host_name = gethostname();
        }

        return view('installer.pages.database-config',compact('page_title','host_name'));
    }

    public function databaseConfigSubmit(Request $request, DBHelper $db) {

        $validator = Validator::make($request->all(),[
            'app_name'          => 'required|string|max:150',
            'host'              => 'required|string',
            'db_name'           => 'required|string|max:100',
            'db_user'           => 'required|string',
            'db_user_password'  => 'nullable|string',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validate();

        try{
            $db->create($validated);
        }catch(Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('project.install.migration.view');
    }

    public function migrationView(Helper $helper, URLHelper $url) {

        if(RequirementHelper::step() !== "PASSED") return redirect()->route('project.install.requirements');
        if(ValidationHelper::step() !== "PASSED") return redirect()->route('project.install.validation.form');
        if(DBHelper::step() !== "PASSED") return redirect()->route('project.install.database.config');

        $database_data = DBHelper::getSessionData();

        $page_title = "Installation - Database Migration";
        return view('installer.pages.migration',compact('page_title','database_data'));
    }

    public function migrationSubmit(Request $request, DBHelper $db) {
        try{
            $db->migrate();
        }catch(Exception $e) {
            return back()->with('error',$e->getMessage());
        }
        return redirect()->route('project.install.admin.setup');
    }

    public function accountSetup() {
        $page_title = "Installation - Admin account settings";
        if(RequirementHelper::step() !== "PASSED") return redirect()->route('project.install.requirements');
        if(ValidationHelper::step() !== "PASSED") return redirect()->route('project.install.validation.form');
        if(DBHelper::step() !== "PASSED") return redirect()->route('project.install.database.config');
        if(DBHelper::step('migrate') !== "PASSED") return redirect()->route('project.install.migration.view');
        return view('installer.pages.admin-setup',compact('page_title'));
    }

    public function accountUpdate(Request $request, DBHelper $db) {
        
        $request->validate([
            'email'     => "required|string|email",
            'f_name'    => "required|string",
            'l_name'    => "required|string",
            'password'  => "required|string",
        ],[
            'email.required'    => "Email address is required",
            'email.email'       => "Email address must be an valid email",
            'f_name.required'   => "First name is required",
            'l_name.required'   => "Last name is required",
            'password.required' => "Password field is required",
        ]);

        try{
            $db->updateAccountSettings($request->all());
        }catch(Exception $e) {
            return back()->with('error',$e->getMessage());
        }

        return redirect()->route('project.install.finish');
    }

    public function finish() {
        $page_title = "Installation - Finish";
        if(RequirementHelper::step() !== "PASSED") return redirect()->route('project.install.requirements');
        if(ValidationHelper::step() !== "PASSED") return redirect()->route('project.install.validation.form');
        if(DBHelper::step() !== "PASSED") return redirect()->route('project.install.database.config');
        if(DBHelper::step('migrate') !== "PASSED") return redirect()->route('project.install.migration.view');
        if(DBHelper::step('admin_account' !== "PASSED")) return redirect()->route('project.install.admin.setup');

        return view('installer.pages.finish',compact('page_title'));
    }

}