<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHealthData extends Model
{
    use HasFactory;

    protected $table = 'user_health_data';

    protected $fillable = [
        'name',
        'age',
        'weight',
        'height',
        'bmi',
        'systolic_min',
        'systolic_max',
        'diastolic_min',
        'diastolic_max',
        'status',
        'result',
    ];

    protected $casts = [
        'age'           => 'integer',
        'weight'        => 'float',
        'height'        => 'float',
        'bmi'           => 'float',
        'systolic_min'  => 'integer',
        'systolic_max'  => 'integer',
        'diastolic_min' => 'integer',
        'diastolic_max' => 'integer',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Normal'   => 'status-normal',
            'Elevated' => 'status-elevated',
            'High'     => 'status-high',
            'Low'      => 'status-low',
            default    => 'status-normal',
        };
    }

    public function getBmiCategoryAttribute(): string
    {
        if (!$this->bmi) return 'N/A';

        return match (true) {
            $this->bmi < 18.5 => 'Underweight',
            $this->bmi < 25.0 => 'Normal weight',
            $this->bmi < 30.0 => 'Overweight',
            default           => 'Obese',
        };
    }
}
