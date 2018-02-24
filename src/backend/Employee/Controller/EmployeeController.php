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

namespace Omed\Employee\Controller;

use Omed\Resource\Entity\Employee;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmployeeController.
 */
class EmployeeController
{
    /**
     * Get employee profile.
     *
     * @Route(
     *     name="api_employees_get_profile",
     *     path="/employees/{id}/profile",
     *     defaults={
     *         "_api_resource_class"=Employee::class,
     *         "_api_item_operation_name"="employeeProfile"
     *     },
     *     methods="GET"
     * )
     *
     * @return Employee
     */
    public function getProfile($data)
    {
        return $data;
    }

    /**
     * Update employee profile.
     *
     * @Route(
     *     name="api_employees_put_profile",
     *     path="/employees/{id}/profile",
     *     defaults={
     *         "_api_resource_class"=Employee::class,
     *         "_api_item_operation_name"="employeeProfileUpdate"
     *     },
     *     methods="PUT"
     * )
     *
     * @return Employee
     */
    public function updateProfile($data)
    {
        return $data;
    }
}
