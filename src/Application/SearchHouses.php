<?php

namespace App\Application;

use App\Domain\HouseRepository;

final class SearchHouses
{
    private $repository;

    public function __construct(HouseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search($sortedBy = null)
    {
        return $this->repository->searchAll($sortedBy);
    }
}