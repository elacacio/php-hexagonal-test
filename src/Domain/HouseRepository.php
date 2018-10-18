<?php

namespace App\Domain;


interface HouseRepository
{
    public function search(int $houseId);

    public function searchAll($sortedBy = null);

    public function save(House $house);
}