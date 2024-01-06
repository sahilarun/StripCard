<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\Extension;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Response;


class ExtensionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Extensions";
        $extensions = Extension::orderBy('id', 'desc')->paginate(8);
        return view('admin.sections.extensions.index', compact(
            'page_title',
            'extensions',
        ));
    }

    public function update(Request $request, $id)
    {
        $extension = Extension::findOrFail($id);
        $validation_rule = [];
        foreach ($extension->shortcode as $key => $val) {
            $validation_rule[$key] = "required";
        }

        $request->validate($validation_rule);
        $shortcode = json_decode(json_encode($extension->shortcode), true);
        foreach ($shortcode as $key => $code) {
            $shortcode[$key]['value'] = $request->$key;
        }
        $extension->shortcode = $shortcode;
        $extension->update();
        return back()->with(['success' => ['Extension has been udpate successfully']]);
    }


    public function statusUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->validate();
        $item_id = $validated['data_target'];

        $extension = Extension::find($item_id);
        if (!$extension) {
            $error = ['error' => ['Extension is not found!.']];
            return Response::error($error,null,404);
        }

        try {
            $extension->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        } catch (Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Extension status is updated successfully!']];
        return Response::success($success,null,200);
    }
}
