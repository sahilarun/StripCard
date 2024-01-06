<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'last_edit_by' => 'integer',
        'status' => 'integer',
    ];
    public function scopeDefault($query) {
        return $query->where("status",true);
    }

    public function getEditDataAttribute() {
        $data = [];
        
        $data = [
            'id'        => $this->id,
            'name'      => $this->name,
            'code'      => $this->code,
        ];

        return json_encode($data);
    }
}
