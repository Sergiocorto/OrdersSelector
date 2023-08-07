<?php

namespace App\Controller;

use App\Services\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use League\Csv\Reader;
use Doctrine\DBAL\Types\Types;


class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    #[Route('/order/find')]
    public function find(Request $request): JsonResponse
    {
        $data = $this->orderService->find($request);
        return new JsonResponse($data);
    }
}
