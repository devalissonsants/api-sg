<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class Company extends Model
{
    use SoftDeletes;
    protected $table = 'companies';
    protected $fillable = ['company_name', 'trade_name', 'cnpj', 'cep', 'cities_id', 'address', 'number', 'complement', 'district'];
    protected $hidden = ['cities_id'];

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'cities_id');
    }
}
