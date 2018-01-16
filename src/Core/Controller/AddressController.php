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

namespace Omed\Core\Controller;

use Omed\Core\Service\AddressService;
use Omed\Entity\Customer;
use Omed\Entity\Employee;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EmployeeService.
 */
class AddressController
{
    /**
     * @param AddressService $service
     * @param Request        $request
     *
     * @return JsonResponse
     */
    public function addForEmployeeAction($id, AddressService $service, Request $request)
    {
        return $service->createNew(Employee::class, $id, $request);
    }

    /**
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
