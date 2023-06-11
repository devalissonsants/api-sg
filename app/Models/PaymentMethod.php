<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class PaymentMethod extends Model
{
    use softDeletes;
    protected $fillable = ['name', 'company_id'];
    protected $table='payment_methods';

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
