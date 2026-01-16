<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /** @use HasFactory<\Database\Factories\TemplateFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'type', 'image'];

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
