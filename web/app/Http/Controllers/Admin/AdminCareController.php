<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminRoleConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\AdminHasRole;
use App\Models\Admin\AdminRole;
use App\Models\Admin\AdminRoleHasPermission;
use App\Models\Admin\AdminRolePermission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Helpers\Response;
use App\Notifications\Admin\NewAdminCredential;
use App\Notifications\Admin\SendEmailToAll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AdminCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "All Admin";
        $admins = Admin::paginate(10);

        if(system_super_admin() == true) {
            $admin_roles = AdminRole::notSuperAdmin()->active()->get();
        }else {
            $admin_roles = AdminRole::active()->get();
        }
        return view('admin.sections.admin-care.index', compact(
            'page_title',
            'admins',
            'admin_roles',
        ));
    }


    /**
     * Display Send Email to All Admins View
     * @return view
     */
    public function emailAllAdmins()
    {
        $page_title = "Email To Admin";
        return view('admin.sections.admin-care.email-to-admins', compact(
            'page_title',
        ));
    }


    public function sendEmail(Request $request) {
        $validator = Validator::make($request->all(),[
            'subject'       => 'required|string|max:200',
            'message'       => 'required|string|max:2000',
        ]);

        $validated = $validator->validate();

        $admins = collect(Admin::get());

        try{
            Notification::send($admins,new SendEmailToAll($validated));
        }catch(Exception $e) {
            return back()->with(['error' => ["Opps! Faild to send mail. Please recheck your mail credentials or reconfigure mail"]]);
        }

        return back()->with(['success' => ['Email send successfully!']]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'         => "required|string|max:60",
            'lastname'          => "required|string|max:60",
            'username'          => "required|string|unique:admins,username|alpha_dash|max:25",
            'email'             => "required|email|unique:admins,email",
            'password'          => "required|min:8",
            'phone'             => "required|string|max:20|unique:admins,phone",
            'image'             => "nullable|mimes:png,jpg,jpeg,webp,svg",
            'role'              => "required|integer|exists:admin_roles,id|max:30",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "admin-add");
        }

        $validated = $validator->validate();
        $validated['password']      = Hash::make($validated['password']);
        $validated['status']        = true;

        if(system_super_admin() == true) {
            // check selected role is super admin or not
            $selected_role = AdminRole::find($validated['role']);
            if($selected_role->name == AdminRoleConst::SUPER_ADMIN) {
                return back()->with(['error' => ['Can\'t assign '. AdminRoleConst::SUPER_ADMIN . ' Role']]);
            }
        }

        if ($request->hasFile("image")) {
            try {
                $image = get_files_from_fileholder($request, "image");
                $upload_file = upload_files_from_path_dynamic($image, "admin-profile");
                $validated['image'] = $upload_file;
            } catch (Exception $e) {
                return back()->with(['error' => ['Opps! Faild to upload image.']]);
            }
        }

        $assign_role = $validated['role'] ?? "";
        $validated = Arr::except($validated,['role']);

        try {
            $created_admin_id = Admin::insertGetId($validated);
            $validated['role']  = $selected_role->name;
            $validated['password'] = $request->password;
            Notification::route('mail',$validated['email'])->notify(new NewAdminCredential($validated));
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        try{
            // assign role
            AdminHasRole::create([
                'admin_id'      => $created_admin_id,
                'admin_role_id' => $assign_role,
                'last_edit_by'  => Auth::user()->id,
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => ['Role assign faild!']]);
        }

        return back()->with(['success' => ['New admin created successfully!']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $target = $request->target ?? $request->edit_email;
        $admin  = Admin::where(function ($q) use ($target) {
            $q->where("username", $target);
        })->orWhere(function ($q) use ($target) {
            $q->where("email", $target);
        })->first();

        if (!$admin) {
            return back()->with(['warning' => ['Opps! Target admin not found!']]);
        }
        $request->merge(['old_image' => $admin->image]);

        $validator = Validator::make($request->all(), [
            'target'            => "required|string",
            'edit_firstname'    => "required|string|max:60",
            'edit_lastname'     => "required|string|max:60",
            'edit_username'     => ["required", "string", "alpha_dash", Rule::unique('admins', 'username')->ignore($admin->id)],
            'edit_email'        => ["required", "string", "email", Rule::unique('admins', 'email')->ignore($admin->id)],
            'edit_phone'        => ["nullable", "string", Rule::unique('admins', 'phone')->ignore($admin->id)],
            'edit_image'        => "nullable|mimes:png,jpg,jpeg,svg,webp",
            'edit_role'         => "required|array",
            'edit_role.*'       => "required|integer",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "admin-edit");
        }

        $validated = $validator->validate();
        $validated = Arr::except($validated, ['target']);

        if(system_super_admin() == true) {
            // check selected role is super admin or not
            $selected_roles = AdminRole::whereIn("id",$validated['edit_role'])->pluck("name")->toArray();
            if(in_array(AdminRoleConst::SUPER_ADMIN,$selected_roles)) {
                return back()->with(['error' => ['Can\'t assign '. AdminRoleConst::SUPER_ADMIN . ' Role']]);
            }
        }

        if ($request->hasFile("edit_image")) {
            $image = get_files_from_fileholder($request, "edit_image");
            $upload_file = upload_files_from_path_dynamic($image, "admin-profile", $admin->image);
            $validated['edit_image'] = $upload_file;
        }

        $validated = replace_array_key($validated, "edit_");

        try {
            $admin->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        $role_data = [];

        if($admin->isSuperAdmin()) {
            $super_admin_role = AdminRole::where("name",AdminRoleConst::SUPER_ADMIN)->first();
            if(!$super_admin_role) {
                $super_admin_role = AdminRole::create([
                    'admin_id'  => $admin->id,
                    'name'      => AdminRoleConst::SUPER_ADMIN,
                    'status'    => true,
                ]);
            }
            $role_data[] = [
                'admin_id'      => $admin->id,
                'admin_role_id' => $super_admin_role->id,
                'last_edit_by'  => Auth::user()->id,
                'created_at'    => now(),
            ];
        }

        foreach($validated['role'] as $item) {
            $role_data[] = [
                'admin_id'      => $admin->id,
                'admin_role_id' => $item,
                'last_edit_by'  => Auth::user()->id,
                'created_at'    => now(),
            ];
        }

        // admin role update
        DB::beginTransaction();
        try{
            // Delete Currency Role
            DB::table('admin_has_roles')->where("admin_id",$admin->id)->delete();
            DB::table('admin_has_roles')->insert($role_data);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Faild to assign role.']]);
        }

        return back()->with(['success' => ['Admin information updated successfully!']]);
    }

    /**
     * Function for show all roles
     */
    public function roleIndex()
    {
        $page_title = "Admin Roles";
        $roles = AdminRole::with('assignRole')->get();
        return view('admin.sections.admin-care.role.index', compact(
            'page_title',
            'roles',
        ));
    }

    /**
     * Function for update admin status
     * @param  \Illuminate\Http\Request  $request
     */
    public function statusUpdate(Request $request) {
        $validator = Validator::make($request->all(),[
            'data_target'       => "required|string|max:100",
            'status'            => "required|boolean",
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->safe()->all();
        $username = $validated['data_target'];

        $admin = Admin::where('username',$username)->first();
        if(!$admin) {
            $error = ['error' => ['Admin not found!']];
            return Response::error($error,null,404);
        }

        try{
            $admin->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error,null,500);
        }

        $success = ['success' => ['Admin status updated successfully!']];
        return Response::success($success,null,200);
    }

    /**
     * Function for create new role for admin
     * @param  \Illuminate\Http\Request  $request
     */
    public function roleStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => "required|string|max:60|unique:admin_roles,name",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "role-add");
        }

        $validated = $validator->validate();
        $validated['admin_id']  = Auth::user()->id;

        try {
            AdminRole::create($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Admin role created successfully!']]);
    }

    /**
     * Function for update admin role information
     * @param  \Illuminate\Http\Request  $request
     */
    public function roleUpdate(Request $request)
    {

        if (!isset($request->target)) {
            return back()->with(['error' => ['Opps! Target not found!']]);
        }

        $role = AdminRole::find($request->target);
        if (!$role) {
            return back()->with(['error' => "Opps! Target role not found!"]);
        }

        $validator = Validator::make($request->all(), [
            'target'        => "required|integer",
            'edit_name'     => ["required", "string", "max:60", Rule::unique("admin_roles", "name")->ignore($role->id)],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "role-edit");
        }

        $validated = $validator->validate();
        $validated['admin_id']  = Auth::user()->id;

        $validated = replace_array_key($validated, "edit_", "");
        $validated = Arr::except($validated, ['target']);

        try {
            $role->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }


        return back()->with(['success' => ["Admin role updated successfully!"]]);
    }


    /**
     * Function for Delete Admin Role
     * @param  \Illuminate\Http\Request  $request
     */
    public function roleRemove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target'        => "required|integer|exists:admin_roles,id",
        ]);

        $validated = $validator->validate();

        $role = AdminRole::find($validated['target']);
        if(!$role) return back()->with(['error' => ['Target role not found!']]);
        if($role->name == AdminRoleConst::SUPER_ADMIN) {
            return back()->with(['error' => ['Super admin role can\'t deletable.']]);
        }

        try {
            $role->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Admin role deleted successfully!']]);
    }


    /**
     * Function for display all permission group
     */
    public function rolePermissionIndex()
    {
        $page_title = "Permission Group";
        $roles = AdminRole::get();
        $permissions = AdminRolePermission::get();
        return view('admin.sections.admin-care.role.permissions', compact(
            "page_title",
            "roles",
            "permissions",
        ));
    }

    /**
     * Function for store new role permission for admin
     * @param  \Illuminate\Http\Request  $request
     */
    public function rolePermissionStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => "required|string|max:60|unique:admin_role_permissions,name",
            'role'      => "required|integer|exists:admin_roles,id|unique:admin_role_permissions,admin_role_id",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "permission-add");
        }

        $validated = $validator->validate();
        $validated['admin_role_id'] = $validated['role'];
        $validated['admin_id']      = Auth::user()->id;
        $validated['slug']          = Str::slug($validated['name']);

        $validated = Arr::except($validated, ['role']);

        try {
            AdminRolePermission::create($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Permission created successfully!']]);
    }


    /**
     * Function for update admin role permission information
     * @param  \Illuminate\Http\Request  $request
     */
    public function rolePermissionUpdate(Request $request)
    {

        if (!isset($request->target)) {
            return back()->with(['error' => ['Target not found!']]);
        }

        $permission = AdminRolePermission::find($request->target);
        if (!$permission) {
            return back()->with(['error' => ['Permission not found!']]);
        }

        $validator = Validator::make($request->all(), [
            'target'        => ["required", "integer", Rule::unique("admin_role_permissions", "id")->ignore($permission->id)],
            'edit_name'     => "required|string|max:60",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with("modal", "permission-edit");
        }


        $validated              = $validator->validate();
        $validated              = Arr::except($validated, ['target']);
        $validated              = replace_array_key($validated, "edit_", "");
        $validated['admin_id']  = Auth::user()->id;
        $validated['slug']      = Str::slug($validated['name']);

        try {
            $permission->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Permission updated successfully!']]);
    }


    /**
     * Function for delete specific permission in admin role
     * @param  \Illuminate\Http\Request  $request
     */
    public function rolePermissionDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target'            => "required|integer|exists:admin_role_permissions,id",
        ]);

        $validated = $validator->validate();

        try {
            AdminRolePermission::find($validated['target'])->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Permission deleted successfully!']]);
    }

    /**
     * Function for view all permission against a speacific Role/Permission
     * @param string $slug
     */
    public function viewRolePermission($slug)
    {
        $permission = AdminRolePermission::where("slug", $slug)->first();
        if (!$permission) {
            return back()->with(['error' => ['Role permission not found!']]);
        }

        $routes = [];
        foreach(get_role_permission_routes() as $item) {
            if(!in_array($item['route'],$permission->hasPermissions()->pluck("route")->toArray())) {
                $routes[] = $item;
            }
        }

        $page_title = "Role Permission (" . $permission->name . ")";

        return view('admin.sections.admin-care.role.assign-permission', compact(
            "permission",
            "page_title",
            "routes",
        ));
    }

    /**
     * Function for assign new permission route against Role/Permission
     * @param  \Illuminate\Http\Request  $request
     * @param string $slug
     */
    public function rolePermissionAssign(Request $request, $slug)
    {
        $permission = AdminRolePermission::where("slug", $slug)->first();
        if (!$permission) {
            return back()->with(['error' => ['Permission not found!']]);
        }

        $validator = Validator::make($request->all(), [
            'title.*'       => "required|string|max:100",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', "permission-assign-add");
        }
        $has_permissions = AdminRoleHasPermission::where("admin_role_permission_id",$permission->id)->pluck("route")->toArray();

        $validated = $validator->validate();

        $new_permissions = array_diff($validated['title'],$has_permissions);

        $routes = get_role_permission_routes();

        $metch_items = [];
        foreach ($routes as $item) {
            foreach ($new_permissions as $innerItem) {
                if ($innerItem == $item['route']) {
                    $metch_items[] = [
                        'route'                         => $item['route'],
                        'title'                         => $item['text'],
                        'admin_role_permission_id'      => $permission->id,
                        'last_edit_by'                  => Auth::user()->id,
                        'created_at'                    => now(),
                    ];
                    break;
                }
            }
        }

        try{
            AdminRoleHasPermission::insert($metch_items);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Permission assign successfully!']]);
    }

    public function rolePermissionAssignDelete(Request $request,$slug) {

        $request->merge(['slug' => $slug]);
        $validator = Validator::make($request->all(),[
            'slug'     => 'required|exists:admin_role_permissions',
            'target'   => 'required|integer',
        ]);
        $validated = $validator->validate();

        $permission = AdminRolePermission::where("slug",$validated['slug'])->first();
        if(!$permission) {
            return back()->with(['error' => ['Permission not found!']]);
        }

        try{
            AdminRoleHasPermission::where("admin_role_permission_id",$permission->id)->where("id",$validated['target'])->delete();
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Permission deleted successfully!']]);
    }

    public function deleteAdmin(Request $request) {
        $validator = Validator::make($request->all(),[
            'target'        => 'required|string|exists:admins,username',
        ]);

        $validated = $validator->validate();

        $admin = Admin::where("username",$validated['target'])->first();
        if($admin->isSuperAdmin()) {
            return back()->with(['warning' => ['Can\'t deletable system super admin']]);
        }

        try{
            $admin->delete();
            delete_file(get_files_path('admin-profile').'/'.$admin->image);
        }catch(Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Admin deleted successfully!']]);
    }

    public function adminSearch(Request $request) {
        $validator = Validator::make($request->all(),[
            'text'  => 'required|string',
        ]);

        if($validator->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }

        $validated = $validator->validate();
        $admins = Admin::notAuth()->search($validated['text'])->select("firstname","lastname","username","email","image","status","phone","admin_role_id")->limit(10)->get();
        return view('admin.components.search.admin-search',compact(
            'admins',
        ));
    }
}
