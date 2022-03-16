<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTypes extends Model
{
    use HasFactory;
    protected $table = 'contact_types';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    protected $guarded = ['created_at', 'updated_at'];
}
