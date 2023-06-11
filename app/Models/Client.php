<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $table = 'clients';
    protected $fillable = ['name', 'cpf_cnpj', 'cep', 'cities_id', 'address', 'number', 'complement', 'district','note', 'company_id'];
    protected $hidden = ['cities_id'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
