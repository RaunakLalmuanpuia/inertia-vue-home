<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'feedback',
        'employee_id',
        'file_path',
        'employer_id'

    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
