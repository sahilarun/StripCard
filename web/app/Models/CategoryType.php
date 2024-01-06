<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "category_types";

    protected $appends = [
        'editData',
    ];

    public function getEditDataAttribute() {

        $data = [
            'id'      => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'type'      => $this->type,
            'status'      => $this->status,
        ];

        return json_encode($data);
    }

    public function scopeSearch($query,$text) {
        $query->Where("name","like","%".$text."%");
    }

}
