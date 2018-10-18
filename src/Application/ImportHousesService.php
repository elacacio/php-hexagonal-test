<?php

namespace App\Application;

use App\Domain\House;
use App\Domain\HouseRepository;

final class ImportHousesService
{
    private $repository;

    public function __construct(HouseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param House[] $houses
     */
    public function doImport($houses): void
    {
        foreach ($houses as $house) {
            if ($this->validateImport($house)) {
                $this->repository->save($house);
            }
        }
    }

    private function validateImport(House $house): bool
    {
        return null === $this->repository->search($house->getId());
    }
}