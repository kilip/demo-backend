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

namespace Demo\Customer\Controller;
use Demo\Entity\Customer;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CustomerController
 *
 * @package Demo\Customer\Controller
 */
class CustomerController
{

    /**
     * Get customer profile
     *
     * @Route(
     *     name="api_customers_get_profile",
     *     path="/customers/{id}/profile",
     *     defaults={
     *         "_api_resource_class"=Customer::class,
     *         "_api_item_operation_name"="customerProfile"
     *     },
     *     methods="GET"
     * )
     *
     *
     */
    public function getProfile($id,$data)
    {
        return $data;
    }

    /**
     * Update customer profile
     *
     * @Route(
     *     name="api_customers_put_profile",
     *     path="/customers/{id}/profile",
     *     defaults={
     *         "_api_resource_class"=Customer::class,
     *         "_api_item_operation_name"="customerProfileUpdate"
     *     },
     *     methods="GET"
     * )
     * @param   string  $id
     * @return  Customer
     */
    public function updateProfile($id, $data)
    {
        return $data;
    }
}
