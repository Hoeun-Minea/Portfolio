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
        'file_data',
        'academic_year',
        'description',
        'is_portfolio',
        'views_count',
        'downloads_count',
    ];

    protected $casts = [
        'is_portfolio' => 'boolean',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
    ];

    /**
     * ទំនាក់ទំនង BelongsTo: ឯកសារនីមួយៗស្ថិតក្រោមប្រភេទមួយជាក់លាក់
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
