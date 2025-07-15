<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class Category extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "ms_category";
    protected $primaryKey = 'id_category';
    public $incrementing = false;
    protected $fillable = [];
}
