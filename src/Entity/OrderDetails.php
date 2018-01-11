<?php

/*
 * This file is part of the Northwind project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Northwind\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderDetails.
 *
 * @ORM\Table(
 *     name="order_details",
 *     indexes={
 *          @ORM\Index(columns={"id"}),
 *          @ORM\Index(columns={"inventory_id"}),
 *          @ORM\Index(columns={"product_id"}),
 *          @ORM\Index(columns={"purchase_order_id"}),
 *          @ORM\Index(columns={"order_id"}),
 *          @ORM\Index(columns={"status_id"})
 *      }
 * )
 * @ORM\Entity
 * @ApiResource()
 */
class OrderDetails
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=18, scale=4, nullable=false, options={"default"="0.0000"})
     */
    private $quantity = 0.0000;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=19, scale=4, nullable=true, options={"default"="0.0000"})
     */
    private $unitPrice = 0.0000;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float", precision=10, scale=0, nullable=false)
     */
    private $discount = 0;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_allocated", type="datetime", nullable=true)
     */
    private $dateAllocated;

    /**
     * @var int|null
     *
     * @ORM\Column(name="purchase_order_id", type="integer", nullable=true)
     */
    private $purchaseOrderId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="inventory_id", type="integer", nullable=true)
     */
    private $inventoryId;

    /**
     * @var OrderDetailsStatus
     *
     * @ORM\ManyToOne(targetEntity="OrderDetailsStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var Products
     *
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     *
     * @return OrderDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param null|string $unitPrice
     *
     * @return OrderDetails
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     *
     * @return OrderDetails
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateAllocated()
    {
        return $this->dateAllocated;
    }

    /**
     * @param \DateTime|null $dateAllocated
     *
     * @return OrderDetails
     */
    public function setDateAllocated($dateAllocated)
    {
        $this->dateAllocated = $dateAllocated;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPurchaseOrderId()
    {
        return $this->purchaseOrderId;
    }

    /**
     * @param int|null $purchaseOrderId
     *
     * @return OrderDetails
     */
    public function setPurchaseOrderId($purchaseOrderId)
    {
        $this->purchaseOrderId = $purchaseOrderId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInventoryId()
    {
        return $this->inventoryId;
    }

    /**
     * @param int|null $inventoryId
     *
     * @return OrderDetails
     */
    public function setInventoryId($inventoryId)
    {
        $this->inventoryId = $inventoryId;

        return $this;
    }

    /**
     * @return OrderDetailsStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param OrderDetailsStatus $status
     *
     * @return OrderDetails
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Orders $order
     *
     * @return OrderDetails
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Products
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Products $product
     *
     * @return OrderDetails
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}
