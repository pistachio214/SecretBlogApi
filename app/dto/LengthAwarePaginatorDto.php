<?php

namespace app\dto;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LengthAwarePaginatorDto
{
    public int $currentPage;

    public int $perPage;

    public int $total;

    public array $data;

    public function __construct(LengthAwarePaginator $lengthAwarePaginator)
    {
        $this->currentPage = $lengthAwarePaginator->currentPage();
        $this->perPage = $lengthAwarePaginator->perPage();
        $this->total = $lengthAwarePaginator->total();
        $this->data = json_decode(json_encode($lengthAwarePaginator->items()), true);
    }

}