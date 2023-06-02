<?php

namespace App\Models;

use App\Notifications\NewBlogNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'body',
        'author'

    ];


    public function category() :BelongsTo  
    {
        return $this->belongsTo(Category::class);
    }


    protected static function boot() {
        parent::boot();
        static::created(function(Blog $blog){

            $users = User::where('is_subscribed',1)->get();
            foreach($users as $user){
                $user->notify(new NewBlogNotification($blog));
            }
        });

    }
}