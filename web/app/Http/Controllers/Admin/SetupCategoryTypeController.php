<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryType;
use Illuminate\Http\Request;

class SetupCategoryTypeController extends Controller
{
    public function categoryView(){
        $page_title = "Setup Currency";
        $allCategory = CategoryType::orderByDesc('default')->paginate(10);
        return view('admin.sections.categoryType.index',compact(
            'page_title',
            'allCategory',
        ));
    }
}
