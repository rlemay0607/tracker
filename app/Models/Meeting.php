<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
        'time',
        'company_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'company_id' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function actionItems(): HasMany
    {
        return $this->hasMany(ActionItem::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
