<?php

namespace App\Domain;


class HouseNotFoundException extends \DomainException
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;

        parent::__construct($this->errorMessage(), $this->errorCode());
    }

    private function errorCode(): string
    {
        return 'house_not_found';
    }

    private function errorMessage(): string
    {
        return sprintf('The house <%s> has not been found', $this->id);
    }
}