<?php

declare(strict_types = 1);

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Behat\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Omed\Entity\Address;
use Omed\Entity\Employee;
use Faker\Factory;
use Omed\Entity\User;
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

    /**
     * @var UserContext
     */
    private $userContext;

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
        $this->userContext = $environment->getContext(UserContext::class);
    }

    /**
     * @Given I send :method request to employees with body:
     * @Given I send :method request to employees
     */
    public function iSendRequestToEmployeesWith($method, PyStringNode $data = null)
    {
        $routeName = 'api_employees_'.strtolower($method).'_collection';
        $url = $this->restContext->generateUrl(
            $routeName,
            array()
        );
        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestTo(
            $method,
            $url,
            $data
        );
    }

    /**
     * @Given I send :method request to employee :name with body:
     * @Given I send :method request to employee :name
     */
    public function iSendRequestToEmployee($method, $name, PyStringNode $body = null)
    {
        $employee = $this->getEmployeeWithName($name, true);
        $routeName = 'api_employees_'.strtolower($method).'_item';
        $url = $this->restContext->generateUrl(
            $routeName,
            array('id' => $employee->getId())
        );
        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestTo(
            $method, $url, $body
        );
    }

    /**
     * @Given I send :method request to employee profile :name with body:
     * @Given I send :method request to employee profile :name
     */
    public function iSendRequestToEmployeeProfile($method, $name, PyStringNode $body = null)
    {
        $employee = $this->getEmployeeWithName($name, true);
        $routeName = 'api_employees_'.strtolower($method).'_profile';
        $url = $this->restContext->generateUrl(
            $routeName,
            array('id' => $employee->getId())
        );
        $this->restContext->iSetHeaderTypeToHydra();
        $this->restContext->iSendARequestTo(
            $method, $url, $body
        );
    }

    /**
     * @Given I don't have any employee data
     */
    public function iDonTHaveAnyEmployeeData()
    {
        $repo = $this->getRepository('Omed:Employee');
        $results = $repo->findAll();
        $em = $this->getEntityManager();
        foreach($results as $employee){
            $em->remove($employee);
            $em->flush();
        }
    }

    /**
     * @Given I don't have any address data
     */
    public function iDonTHaveAnyAddressData()
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection->exec('DELETE from public.employees');
        $connection->commit();
    }

    /**
     * @Given I have employee with data:
     */
    public function iHaveEmployeeWithData(TableNode $table)
    {
        $rows = $table->getRowsHash();

        $this->getEmployeeWithName($rows['name'], true, $rows);
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
     * @param bool   $create
     * @param array  $data
     *
     * @return Employee
     *
     * @throws \Exception
     */
    public function getEmployeeWithName($name, $create = false, array $data = array())
    {
        /* @var \Omed\Entity\Employee $employee */
        $repo = $this->getEntityManager()->getRepository(Employee::class);

        $employee = $repo->findOneBy(array('name' => $name));
        if (null === $employee && $create) {
            $data['name'] = $name;
            $employee = $this->createNewEmployee($data);
        }

        if (null === $employee) {
            throw new \Exception('Can not find employee named: '.$name);
        }

        return $employee;
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

        return $employee;
    }

    /**
     * @Given I am logged in employee
     */
    public function iAmLoggedInEmployee()
    {
        $userContext = $this->userContext;
        $employee = $this->getEmployeeWithName('Omed Employee',true);
        $user = $employee->getLogin();
        $user
            ->setUsername('employee')
            ->setPlainPassword('test')
            ->setRoles([User::ROLE_EMPLOYEE])
        ;
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        $userContext->login($employee->getLogin());
    }
}
