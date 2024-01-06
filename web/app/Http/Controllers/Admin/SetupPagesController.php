<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Response;
use App\Models\Admin\SetupPage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SetupPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Setup Pages";
        $type = Str::slug(GlobalConst::SETUP_PAGE);
        $setup_pages = SetupPage::where('type', $type)->get();
        return view('admin.sections.setup-pages.index',compact(
            'page_title',
            'setup_pages',
        ));
    }

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
        $page_slug = $validated['data_target'];

        $page = SetupPage::where('slug',$page_slug)->first();
        if(!$page) {
            $error = ['error' => ['Page not found!']];
            return Response::error($error,null,404);
        }

        try{
            $page->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            return $e;
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Setup Page status updated successfully!']];
        return Response::success($success,null,200);
    }
}
