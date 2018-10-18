<?php

declare(strict_types=1);

namespace App\Infraestructure\Controller;

use App\Application\SearchHouses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

final class DownloadController extends AbstractController
{
    private $service;
    private $serializer;

    public function __construct(SearchHouses $service, Serializer $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    public function downloadAction(Request $request): Response
    {
        $houses = $this->service->search($request->get('sortedBy'));

        $this->createFile($this->serializer->serialize($houses, 'json'));

        return $this->file('houses_json');
    }

    private function createFile($data): void
    {
        $handle = fopen('houses_json', 'wb');

        fwrite($handle, $data);

        fclose($handle);
    }
}

