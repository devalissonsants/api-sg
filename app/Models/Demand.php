<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\State;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class Demand extends Model
{
    use SoftDeletes;
    protected $table='demands';
    protected $fillable = ['demand_date', 'company_id', 'client_id', 'payment_method_id', 'amount', 'paid_out', 'note'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }
}
