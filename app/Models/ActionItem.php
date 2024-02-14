<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'due_date',
        'status',
        'title',
        'meeting_id',
        'contact_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'due_date' => 'date',
        'meeting_id' => 'integer',
        'contact_id' => 'integer',
        'document' => 'array',
    
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
