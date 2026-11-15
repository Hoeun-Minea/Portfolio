<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * ទំនាក់ទំនង One-to-Many: ប្រភេទមួយ មានឯកសារច្រើន
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
