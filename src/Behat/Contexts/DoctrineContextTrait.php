<?php

declare(strict_types=1);

/*
 * This file is part of the Demo project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Demo\Behat\Contexts;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ConnectionRegistry;
use Doctrine\Common\Persistence\ManagerRegistry as DoctrineRegistry;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

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

    private function checkDatabase()
    {
        /* @var ConnectionRegistry $conn */
        $connectionName = $this->doctrine->getDefaultConnectionName();
        $params = $this->doctrine->getConnection($connectionName)->getParams();
        $hasPath = isset($params['path']);
        $name = $hasPath ? $params['path'] : (isset($params['dbname']) ? $params['dbname'] : false);
        $path = $params['path'];
        unset($params['dbname'], $params['path'], $params['url']);
        if (!is_file($path)) {
            $tmpConnection = DriverManager::getConnection($params);
            $tmpConnection->connect();
            $tmpConnection->getSchemaManager()->createDatabase($name);
            $schemaTool = new SchemaTool($this->getEntityManager());
            $classes = $this->getEntityManager()->getMetadataFactory()->getAllMetadata();
            $schemaTool->updateSchema($classes, true);
        }
    }

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
        $this->checkDatabase();
    }

    protected function getRepository($name)
    {
        $this->doctrine->getRepository($name);
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
    }
}
