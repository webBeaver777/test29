<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $brand_id
 * @property int $car_model_id
 * @property int $user_id
 * @property int|null $year
 * @property int|null $mileage
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\CarModel $carModel
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCarModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereMileage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 *
 * @mixin \Eloquent
 */
class Car extends Model
{
    protected $fillable = [
        'brand_id',
        'car_model_id',
        'user_id',
        'year',
        'mileage',
        'color',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
