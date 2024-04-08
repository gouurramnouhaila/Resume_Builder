<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'location', 'start_date', 'end_date', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'required|string',
        ];
    }
    public function setStartDateAttribute($value): void
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('Y-m-d', $value);
    }

    public function setEndDateAttribute($value): void
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat('Y-m-d', $value) : null;
    }

    public function getStartDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getEndDateAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}
