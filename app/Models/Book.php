<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CollectorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Book extends Model
{
    /** @use HasFactory<CollectorFactory> */
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'type',
        'collector_id',
    ];

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

    public static array $types = [
        'Fiction',
        'Non-Fiction',
        'Technical',
        'Self-Help',
    ];

    public static function getTypes(): array
    {
        return self::$types;
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class);
    }
}
