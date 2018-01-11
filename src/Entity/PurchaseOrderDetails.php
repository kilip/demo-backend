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
 * PurchaseOrderDetails.
 *
 * @ORM\Table(
 *     name="purchase_order_details",
 *     indexes={
 *          @ORM\Index(columns={"id"}),
 *          @ORM\Index(columns={"inventory_id"}),
 *          @ORM\Index(columns={"purchase_order_id"}),
 *          @ORM\Index(columns={"product_id"})
 *
 *     }
 * )
 * @ORM\Entity
 * @ApiResource()
 */
class PurchaseOrderDetails
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
     * @ORM\Column(name="quantity", type="decimal", precision=18, scale=4, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_cost", type="decimal", precision=19, scale=4, nullable=false)
     */
    private $unitCost;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_received", type="datetime", nullable=true)
     */
    private $dateReceived;

    /**
     * @var bool
     *
     * @ORM\Column(name="posted_to_inventory", type="boolean", nullable=false)
     */
    private $postedToInventory = false;

    /**
     * @var InventoryTransactions
     *
     * @ORM\ManyToOne(targetEntity="InventoryTransactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inventory_id", referencedColumnName="id")
     * })
     */
    private $inventory;

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
     * @var PurchaseOrders
     *
     * @ORM\ManyToOne(targetEntity="PurchaseOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purchase_order_id", referencedColumnName="id")
     * })
     */
    private $purchaseOrder;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPostedToInventory()
    {
        return $this->isPostedToInventory();
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
     * @return PurchaseOrderDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * @param string $unitCost
     *
     * @return PurchaseOrderDetails
     */
    public function setUnitCost($unitCost)
    {
        $this->unitCost = $unitCost;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateReceived()
    {
        return $this->dateReceived;
    }

    /**
     * @param \DateTime|null $dateReceived
     *
     * @return PurchaseOrderDetails
     */
    public function setDateReceived($dateReceived)
    {
        $this->dateReceived = $dateReceived;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPostedToInventory()
    {
        return $this->postedToInventory;
    }

    /**
     * @param bool $postedToInventory
     *
     * @return PurchaseOrderDetails
     */
    public function setPostedToInventory($postedToInventory)
    {
        $this->postedToInventory = $postedToInventory;

        return $this;
    }

    /**
     * @return InventoryTransactions
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * @param InventoryTransactions $inventory
     *
     * @return PurchaseOrderDetails
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

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
     * @return PurchaseOrderDetails
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return PurchaseOrders
     */
    public function getPurchaseOrder()
    {
        return $this->purchaseOrder;
    }

    /**
     * @param PurchaseOrders $purchaseOrder
     *
     * @return PurchaseOrderDetails
     */
    public function setPurchaseOrder($purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }
}
