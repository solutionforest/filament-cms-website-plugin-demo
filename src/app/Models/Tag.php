<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Tag extends Model
{
    use NodeTrait;

    protected $guarded = ['id'];
}
