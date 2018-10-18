<?php

namespace App\Infraestructure\Command;

use App\Application\ImportHousesService;
use App\Domain\House;
use App\Domain\ImportHouses;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportHousesCommand extends Command implements ImportHouses
{
    private $service;

    private const RESOURCE = 'http://feeds.spotahome.com/trovit-Ireland.xml';

    public function __construct(ImportHousesService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->import();
    }

    public function import(): void
    {
        $content = file_get_contents(self::RESOURCE);

        $houses = $this->parseXml(new \SimpleXMLElement($content));

        $this->service->doImport($houses);
    }

    private function parseXml($xmlFile): array
    {
        foreach ($xmlFile as $property) {
            $houses[] = $this->buildHouse($property);
        }
        return $houses;
    }

    private function buildHouse($property)
    {
        $id = (int)$property->id;
        $title = trim($property->title);
        $link = trim($property->url);
        $city = trim($property->city);
        $picture = isset($property->pictures->picture[0]) ? $property->pictures->picture[0]->picture_url : null;

        return House::create($id, $title, $link, $city, $picture);
    }
}
