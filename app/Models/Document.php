<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'academic_year',
        'description',
        'is_portfolio',
    ];

    protected $casts = [
        'is_portfolio' => 'boolean',
    ];

    /**
     * ទំនាក់ទំនង BelongsTo: ឯកសារនីមួយៗស្ថិតក្រោមប្រភេទមួយជាក់លាក់
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
