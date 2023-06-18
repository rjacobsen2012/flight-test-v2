<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Drone
 * @package App\Models
 *
 * @property int id
 * @property string uuid
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Drone drone
 * @property Collection|GpsFrame[] gpsFrames
 * @property Collection|GpsFrame[] gpsFramesFirst
 * @property Collection|GpsFrame[] gpsFramesLast
 */
class Flight extends Model
{
    protected $guarded = ['id'];

    public function drone(): BelongsTo
    {
        return $this->belongsTo(Drone::class);
    }

    public function gpsFrames(): HasMany|GpsFrame
    {
        return $this->hasMany(GpsFrame::class);
    }

    public function gpsFramesFirst(): HasMany
    {
        return $this->gpsFrames()->orderedFirst();
    }

    public function gpsFramesLast(): HasMany
    {
        return $this->gpsFrames()->orderedLast();
    }
}
