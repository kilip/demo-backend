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

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Demo\Entity\Employee;
use Faker\Factory;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class EmployeeContext implements Context
{
    use KernelDictionary;
    use DoctrineContextTrait;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->setDoctrine($doctrine);
    }

    /**
     * @Given I don't have any employee data
     */
    public function iDonTHaveAnyEmployeeData()
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->delete('Demo:Employee', 'e')
        ;
        $qb->getQuery()->execute();
    }

    /**
     * @Given I have employee with data:
     */
    public function iHaveEmployeeWithData(TableNode $table)
    {
        $faker = Factory::create();

        $defaults = array(
            'name' => $faker->name('male'),
            'email' => $faker->companyEmail,
            'birthDate' => $faker->dateTimeBetween('-50 years', '-20 years'),
            'gender' => 'M',
        );
        $data = array_merge($defaults, $table->getRowsHash());

        $employee = new Employee();
        $employee
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setBirthDate($data['birthDate'])
            ->setGender($data['gender'])
        ;

        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
    }
}
