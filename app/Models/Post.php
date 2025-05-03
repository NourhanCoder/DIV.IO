<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class);
    }

    //لعرض صوره افتراضيه بحيث ان لو البوست ملهوش صوره
    public function image()
    {
        if($this->image){
            return asset('public/images/' . $this->image);
        }
        return asset( "default.jpg");
    }
}
