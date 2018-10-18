<?php

namespace App\Domain;

final class House
{
    private $id;
    private $title;
    private $link;
    private $city;
    private $picture;

    private function __construct(int $id, string $title, string $link, string $city, string $picture)
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->city = $city;
        $this->picture = $picture;
    }

    public static function create(int $id, string $title, string $link, string $city, string $picture): House
    {
        if (false === filter_var($link, FILTER_VALIDATE_URL)) {
            throw new HouseException();
        }

        return new self($id, $title, $link, $city, $picture);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }
}
