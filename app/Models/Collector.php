<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CollectorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Collector extends Model
{
    /** @use HasFactory<CollectorFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
