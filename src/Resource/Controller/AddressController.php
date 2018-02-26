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

namespace Omed\Resource\Controller;

use Omed\Resource\Service\AddressService;
use Omed\Resource\Entity\Customer;
use Omed\Resource\Entity\Employee;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Handle address creation for Customer and Employee.
 */
class AddressController
{
    /**
     * @Route(
     *     name="add_employee_address",
     *     path="/addresses/employee/{id}",
     *     methods={"POST"},
     *     defaults={
     *          "_api_resource_class"="Omed\Resource\Entity\Address"
     *     }
     * )
     *
     * @param \Omed\Resource\Service\AddressService $service
     * @param Request                               $request
     *
     * @return JsonResponse
     */
    public function addForEmployeeAction($id, AddressService $service, Request $request)
    {
        return $service->createNew(Employee::class, $id, $request);
    }

    /**
     * @Route(
     *     name="add_customer_address",
     *     path="/addresses/customer/{id}",
     *     methods={"POST"},
     *     defaults={
     *          "_api_resource_class"="Omed\Resource\Entity\Address"
     *     }
     * )
     *
     * @param AddressService $service
     * @param Request        $request
     *
     * @return JsonResponse
     */
    public function addForCustomerAction($id, AddressService $service, Request $request)
    {
        return $service->createNew(Customer::class, $id, $request);
    }
}
