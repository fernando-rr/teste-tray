<?php

namespace App\DTOs;

use JsonSerializable;

/**
 * DTO de dados paginados
 * @package App\DTOs
 */
class PaginatedDataDTO implements JsonSerializable
{
    public $data;
    public $total;
    public $perPage;
    public $currentPage;
    public $lastPage;

    public function __construct($data, $total, $perPage, $currentPage, $lastPage)
    {
        $this->data        = $data;
        $this->total       = $total;
        $this->perPage     = $perPage;
        $this->currentPage = $currentPage;
        $this->lastPage    = $lastPage;
    }

    public function jsonSerialize()
    {
        return [
            'data'         => $this->data,
            'total'        => $this->total,
            'per_page'     => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page'    => $this->lastPage,
        ];
    }
}
