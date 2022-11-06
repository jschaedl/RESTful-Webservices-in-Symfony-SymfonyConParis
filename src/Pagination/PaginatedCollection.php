<?php

declare(strict_types=1);

namespace App\Pagination;

final class PaginatedCollection
{
    private array $items;
    private int $total;
    private int $count;

    public function __construct(\Iterator $items, int $total)
    {
        $this->items = iterator_to_array($items);
        $this->total = $total;
        $this->count = \count($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
