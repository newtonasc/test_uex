<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'phone', 'cpf', 'address', 'number', 'neighborhood', 'city', 'state', 'cep', 'latitude', 'longitude', 'type_id'];
    protected $guarded = ['created_at', 'updated_at'];

    public function type_id() {
        return $this->hasOne('App\ContactTypes');
    }
}
