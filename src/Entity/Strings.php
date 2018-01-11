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
 * Strings.
 *
 * @ORM\Table(name="strings")
 * @ORM\Entity
 * @ApiResource()
 */
class Strings
{
    /**
     * @var int
     *
     * @ORM\Column(name="string_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stringId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="string_data", type="string", length=255, nullable=true)
     */
    private $stringData;

    /**
     * @return int
     */
    public function getStringId()
    {
        return $this->stringId;
    }

    /**
     * @return null|string
     */
    public function getStringData()
    {
        return $this->stringData;
    }

    /**
     * @param null|string $stringData
     *
     * @return Strings
     */
    public function setStringData($stringData)
    {
        $this->stringData = $stringData;

        return $this;
    }
}
