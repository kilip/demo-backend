<?php

declare(strict_types=1);

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Behat\Contexts;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ManagerRegistry as DoctrineRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

trait DoctrineContextTrait
{
    /**
     * @var DoctrineRegistry
     */
    protected $doctrine;

    /**
     * @var ORMPurger
     */
    protected $purger;

    /**
     * @return DoctrineRegistry
     */
    public function getDoctrine(): DoctrineRegistry
    {
        return $this->doctrine;
    }

    /**
     * @param DoctrineRegistry $doctrine
     */
    public function setDoctrine(DoctrineRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param string $name
     *
     * @return ObjectRepository
     */
    protected function getRepository($name)
    {
        return $this->doctrine->getRepository($name);
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @return ORMPurger
     */
    protected function getPurger()
    {
        return $this->purger;
    }

    protected function purge()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
        $this->getEntityManager()->flush();
    }
}
