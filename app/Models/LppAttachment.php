<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LppAttachment extends Model
{
    protected $fillable = [
        'lpp_id',
        'attachment_type',
        'file_path',
        'link_url',
    ];

    public function lpp()
    {
        return $this->belongsTo(Lpp::class);
    }
}
