<?php


namespace App\Services;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class OrderService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find(Request $request)
    {
        $shipToName = $request->query->get('ship_to_name');
        $customerEmail = $request->query->get('customer_email');
        $status = $request->query->get('status');
        $pagination = $request->query->get('pagination') ? $request->query->get('pagination') : 2;

        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('e')
            ->from(Order::class, 'e');

        if ($shipToName) {
            $queryBuilder
                ->andWhere('e.shipToName = :shipToName')
                ->setParameter('shipToName', $shipToName);
        }

        if ($customerEmail) {
            $queryBuilder
                ->andWhere('e.customerEmail = :customerEmail')
                ->setParameter('customerEmail', $customerEmail);
        }

        if ($status) {
            $queryBuilder
                ->andWhere('e.status = :status')
                ->setParameter('status', $status);
        }

        if ($pagination) {
            $perPage = (int)$pagination;
            $queryBuilder->setMaxResults($perPage);
        }

        $query = $queryBuilder->getQuery();
        return $results = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}