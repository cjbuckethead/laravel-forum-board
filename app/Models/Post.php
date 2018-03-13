<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: cjbm2994
 * Date: 13/03/2018
 * Time: 12:27 PM
 */

class Post extends Model
{
    protected $fillable = ['contents', 'title'];

}