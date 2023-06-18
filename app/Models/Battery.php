<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Battery
 * @package App\Models
 *
 * @property int id
 * @property string battery_name
 * @property string battery_sn
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Drone drone
 * @property Collection|BatteryFrame[] batteryFrames
 * @property Collection|BatteryFrame[] batteryFramesFirst
 * @property Collection|BatteryFrame[] batteryFramesLast
 */
class Battery extends Model
{
    protected $guarded = ['id'];

    public function drone(): BelongsTo
    {
        return $this->belongsTo(Drone::class);
    }

    public function batteryFrames(): HasMany|BatteryFrame
    {
        return $this->hasMany(BatteryFrame::class);
    }

    public function batteryFramesFirst(): HasMany
    {
        return $this->batteryFrames()->orderedFirst();
    }

    public function batteryFramesLast(): HasMany
    {
        return $this->batteryFrames()->orderedLast();
    }
}
