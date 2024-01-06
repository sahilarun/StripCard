<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqSection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "faq_sections";

    protected $appends = [
        'editData',
    ];

    public function getEditDataAttribute() {

        $data = [
            'id'      => $this->id,
            'category_id'      => $this->category_id,
            'question'      => $this->question,
            'answer'      => $this->answer,
            'status'      => $this->status,
        ];

        return json_encode($data);
    }
    public function category()
    {
        return $this->belongsTo(CategoryType::class,'category_id','id');
    }
    public function scopeSearch($query,$text) {
        $query->Where("name","like","%".$text."%");
    }
}
