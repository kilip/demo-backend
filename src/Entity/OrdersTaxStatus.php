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
 * OrdersTaxStatus.
 *
 * @ORM\Table(name="orders_tax_status")
 * @ORM\Entity
 * @ApiResource()
 */
class OrdersTaxStatus
{
    /**
     * @var bool
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_status_name", type="string", length=50, nullable=false)
     */
    private $taxStatusName;

    /**
     * @return bool
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTaxStatusName()
    {
        return $this->taxStatusName;
    }

    /**
     * @param string $taxStatusName
     *
     * @return OrdersTaxStatus
     */
    public function setTaxStatusName($taxStatusName)
    {
        $this->taxStatusName = $taxStatusName;

        return $this;
    }
}
