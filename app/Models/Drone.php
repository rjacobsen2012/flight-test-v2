<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Drone
 * @package App\Models
 *
 * @property int id
 * @property string aircraft_name
 * @property string aircraft_sn
 * @property int battery_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Flight[] flights
 * @property Collection|Battery[] batteries
 */
class Drone extends Model
{
    protected $guarded = ['id'];

    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }

    public function batteries(): HasMany
    {
        return $this->hasMany(Battery::class);
    }
}
