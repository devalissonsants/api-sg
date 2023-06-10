<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class State extends Model
{
    use softDeletes;
    protected $fillable = ['title', 'country_id','uf'];
    protected $table='states';
    protected $appends = ['linked_cities'];

    public function cities(){
        return $this->hasMany(City::class, 'states_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    //delete relationship
    public static function boot() {
        parent::boot();
        self::deleting(function($state) {
            $state->cities()->delete();
        });
    }
}
