<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'date',
        'type',
        'added_by'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public const TYPES = [
        0 => 'PPC',
        1 => 'TikTok',
        2 => 'SMM',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? 'Unknown';
    }

    public function added(){
        return $this->hasOne(User::class, 'id', 'added_by');
    }
}
