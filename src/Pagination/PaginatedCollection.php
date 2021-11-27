<?php

declare(strict_types=1);

namespace App\Pagination;

use Symfony\Component\Serializer\Annotation\SerializedName;

final class PaginatedCollection
{
    private array $items;
    private int $total;
    private int $count;

    private array $links;

    public function __construct(\Iterator $items, int $total)
    {
        $this->items = iterator_to_array($items);
        $this->total = $total;
        $this->count = \count($this->items);
    }

    public function addLink(string $rel, string $href): self
    {
        $this->links[$rel]['href'] = $href;

        return $this;
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

    #[SerializedName('_links')]
    public function getLinks(): ?array
    {
        return $this->links;
    }
}
