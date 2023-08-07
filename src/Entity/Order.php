<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $purchase_date = null;

    #[ORM\Column(length: 255)]
    private ?string $ship_to_name = null;

    #[ORM\Column(length: 255)]
    private ?string $customer_email = null;

    #[ORM\Column]
    private ?float $grant_total = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPurchaseDate(): ?string
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(string $purchaseDate): self
    {
        $this->purchase_date = $purchaseDate;

        return $this;
    }

    public function getShipToName(): ?string
    {
        return $this->ship_to_name;
    }

    public function setShipToName(string $shipToName): self
    {
        $this->ship_to_name = $shipToName;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customer_email;
    }

    public function setCustomerEmail(string $customerEmail): self
    {
        $this->customer_email = $customerEmail;

        return $this;
    }

    public function getGrantTotal(): ?float
    {
        return $this->grant_total;
    }

    public function setGrantTotal(float $grantTotal): self
    {
        $this->grant_total = $grantTotal;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
