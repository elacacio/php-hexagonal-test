<?php

declare(strict_types=1);

namespace App\Infraestructure\Controller;

use App\Application\SearchHouses;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

final class HouseController extends AbstractController
{
    private $service;
    private $serializer;

    public function __construct(SearchHouses $service, Serializer $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    public function listAction(Request $request): Response
    {
        $houses = $this->service->search($request->get('sortedBy'));

        return new JsonResponse($this->serializer->normalize($houses, 'json'), 200);
    }
}
