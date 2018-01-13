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
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Demo\Entity\Address;
use Demo\Entity\Employee;
use Faker\Factory;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class EmployeeContext implements Context
{
    use KernelDictionary;
    use DoctrineContextTrait;

    /**
     * @var Employee
     */
    private $currentEmployee;

    /**
     * @var RestContext
     */
    private $restContext;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->setDoctrine($doctrine);
    }

    /**
     * @param BeforeScenarioScope $scope
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->restContext = $environment->getContext(RestContext::class);
    }

    /**
     * @Given I don't have any employee data
     */
    public function iDonTHaveAnyEmployeeData()
    {
        /*$qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->delete('Demo:Employee', 'e')
        ;
        $qb->getQuery()->execute();
        $this->getEntityManager()->flush();*/

        $this->purge();
    }

    /**
     * @Given I don't have any address data
     */
    public function iDonTHaveAnyAddressData()
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder()
                   ->delete('Demo:Address', 'a')
        ;
        $qb->getQuery()->execute();
        $this->getEntityManager()->flush();
    }

    /**
     * @Given I have employee with data:
     */
    public function iHaveEmployeeWithData(TableNode $table)
    {
        $rows = $table->getRowsHash();
        $employee = $this->getEmployeeWithName($rows['name']);
        if (!$employee instanceof Employee) {
            $this->createNewEmployee($rows);
        }
    }

    /**
     * @Given I have address for employee named :name
     */
    public function iHaveAddressForEmployeeNamed($name)
    {
        $employee = $this->getEmployeeWithName($name);
        if (!$employee instanceof Employee) {
            $employee = $this->createNewEmployee(array('name' => $name));
        }
        if (0 === $employee->getAddresses()->count()) {
            $faker = Factory::create();
            $address = new Address();
            $address
                ->setAddress($faker->address)
                ->setCity($faker->city)
            ;
            $employee->addAddress($address);
            $this->getEntityManager()->persist($employee);
            $this->getEntityManager()->flush();
        }
        $this->currentEmployee = $employee;
    }

    /**
     * @Given I send POST request to add employee address for :name with body:
     *
     * @param $name
     */
    public function iSendPostRequestToAddAddressForEmployee($name, PyStringNode $body = null)
    {
        $employee = $this->getEmployeeWithName($name);
        $url = $this->restContext->generateUrl(
            'add_employee_address',
            array('id' => $employee->getId())
        );
        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestTo('POST', $url, $body);
    }

    /**
     * @Given I send :method request to his first address with:
     * @Given I send :method request to his first address
     */
    public function iSendUpdateRequestToHisFirstAddressWith($method, PyStringNode $body = null)
    {
        $method = strtolower($method);
        $routeName = 'api_addresses_'.$method.'_item';
        $addresses = $this->currentEmployee->getAddresses();
        $url = $this->restContext->generateUrl(
            $routeName,
            array('id' => $addresses[0]->getId())
        );
        $this->restContext->iSendARequestTo($method, $url, $body);
    }

    /**
     * @Given I request addresses for employee :name
     */
    public function iRequestAddressesForEmployee($name)
    {
        $employee = $this->getEmployeeWithName($name);
        $url = $this->restContext->generateUrl(
            'api_employees_addresses_get_subresource',
            array('id' => $employee->getId())
        );
        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestTo('GET', $url);
    }

    /**
     * @param string $name
     *
     * @return Employee
     */
    public function getEmployeeWithName($name)
    {
        $repo = $this->getEntityManager()->getRepository(Employee::class);

        return $repo->findOneBy(array('name' => $name));
    }

    private function createNewEmployee(array $data)
    {
        $faker = Factory::create();
        $defaults = array(
            'name' => $faker->name('male'),
            'email' => $faker->companyEmail,
            'birthDate' => $faker->dateTimeBetween('-50 years', '-20 years'),
            'gender' => 'M',
        );
        $address = null;
        if (isset($data['address'])) {
            $address = new Address();
            $address->setAddress($data['address']);
            $address->setCity($faker->city);
            unset($data['address']);
        }
        $data = array_merge($defaults, $data);

        $employee = new Employee();
        $employee
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setBirthDate($data['birthDate'])
            ->setGender($data['gender'])
        ;
        if (null !== $address) {
            $employee->addAddress($address);
        }

        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
    }
}
