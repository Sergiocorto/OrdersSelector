<?php


namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use App\Entity\Order;


class OrderImporter
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importOrdersFromCsv(string $csvFilePath): void
    {
        try {
            $csv = Reader::createFromPath($csvFilePath);
            $csv->setHeaderOffset(0);

            $batchSize = 1000;
            $this->entityManager->getConnection()->beginTransaction();
            $orderRepository = $this->entityManager->getRepository(Order::class);
            foreach ($csv->getRecords() as $record) {
                $batchSize--;
                $order = $orderRepository->findOneBy(['id' => $record['id']]);
                if (!$order) {
                    $order = new Order();
                    $order->setId($record['id']);
                }

                $order->setPurchaseDate($record[' purchase date']);
                $order->setShipToName($record[' ship-to name']);
                $order->setCustomerEmail($record[' customer email']);
                $order->setGrantTotal(floatval($record[' grant total (purchased)']));
                $order->setStatus($record[' status']);

                $this->entityManager->persist($order);

                if ($batchSize === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->getConnection()->commit();
                    $this->entityManager->clear();
                    $batchSize = 1000;
                }
            }

            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
        }
    }

    public function importOrdersFromXml(string $xmlFilePath): void
    {
        try{
            $xmlContent = file_get_contents($xmlFilePath);
            $data = simplexml_load_string($xmlContent);
            $batchSize = 1000;
            $this->entityManager->getConnection()->beginTransaction();
            $orderRepository = $this->entityManager->getRepository(Order::class);
            foreach ($data->Worksheet->Table->Row as $row) {
                $id = (string)$row->Cell[0]->Data;
                $purchaseDate = (string)$row->Cell[1]->Data;
                $shipToName = (string)$row->Cell[2]->Data;
                $customerEmail = (string)$row->Cell[3]->Data;
                $grantTotal = (float)$row->Cell[4]->Data;
                $status = (string)$row->Cell[5]->Data;
                $batchSize--;
                $order = $orderRepository->findOneBy(['id' => $id]);
                if (!$order) {
                    $order = new Order();
                    $order->setId($id);
                }

                $order->setPurchaseDate($purchaseDate);
                $order->setShipToName($shipToName);
                $order->setCustomerEmail($customerEmail);
                $order->setGrantTotal(floatval($grantTotal));
                $order->setStatus($status);

                $this->entityManager->persist($order);

                if ($batchSize === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->getConnection()->commit();
                    $this->entityManager->clear();
                    $batchSize = 1000;
                }
            }

            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollBack();
        }
    }
}