<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'template_id', 'status', 'notes'];

    public function template()
    {
        return $this->belongsTo(\App\Models\Template::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
