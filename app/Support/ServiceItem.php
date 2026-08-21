<?php

namespace App\Support;

use Illuminate\Support\Collection;

class ServiceItem
{
    public const CATEGORIES = [
        'perizinan' => 'Perizinan',
        'konstruksi' => 'Konstruksi',
    ];

    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $category,
        public readonly string $icon,
        public readonly string $image,
        public readonly string $short_description,
        public readonly ?string $seo_title = null,
        public readonly ?string $seo_description = null,
        public readonly ?string $description = null,
        public readonly int $sort_order = 0,
    ) {
    }

    public function __get(string $key): ?string
    {
        return match ($key) {
            'category_name' => self::CATEGORIES[$this->category] ?? $this->category,
            'image_url'     => str_starts_with($this->image, 'http')
                ? $this->image
                : asset('storage/' . $this->image),
            default => null,
        };
    }

    public static function all(): Collection
    {
        return collect(config('services.items'))
            ->map(fn (array $item) => new self(...$item))
            ->sortBy('sort_order')
            ->values();
    }

    public static function find(string $slug): ?self
    {
        return static::all()->first(fn (self $service) => $service->slug === $slug);
    }
}
