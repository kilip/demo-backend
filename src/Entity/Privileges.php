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
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Privileges.
 *
 * @ORM\Table(name="privileges")
 * @ORM\Entity
 * @ApiResource()
 */
class Privileges
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
     * @var string|null
     *
     * @ORM\Column(name="privilege_name", type="string", length=50, nullable=true)
     */
    private $privilegeName;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Employees", mappedBy="privilege")
     * @ApiSubresource()
     */
    private $employee;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getPrivilegeName()
    {
        return $this->privilegeName;
    }

    /**
     * @param null|string $privilegeName
     *
     * @return Privileges
     */
    public function setPrivilegeName($privilegeName)
    {
        $this->privilegeName = $privilegeName;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param Collection $employee
     *
     * @return Privileges
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;

        return $this;
    }
}
