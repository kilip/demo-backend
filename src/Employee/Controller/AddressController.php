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

namespace Demo\Employee\Controller;

use ApiPlatform\Core\JsonLd\Serializer\ItemNormalizer;
use ApiPlatform\Core\Hydra\Serializer\ErrorNormalizer;
use Demo\Entity\Address;
use Demo\Entity\AdressableInterface;
use Demo\Entity\Employee;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class EmployeeService.
 *
 * @Route(service="employee.controller.address")
 */
class AddressController
{
    private $em;

    /**
     * @var ErrorNormalizer
     */
    private $errorNormalizer;

    /**
     * @var ItemNormalizer
     */
    private $itemNormalizer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        ManagerRegistry $doctrine,
        $errorNormalizer,
        $itemNormalizer,
        ValidatorInterface $validator
    ) {
        $this->em = $doctrine->getManagerForClass(Employee::class);
        $this->errorNormalizer = $errorNormalizer;
        $this->itemNormalizer = $itemNormalizer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        /* @var Address $address */
        /* @var AdressableInterface $parent */
        $itemNormalizer = $this->itemNormalizer;
        $errorNormalizer = $this->errorNormalizer;
        $validator = $this->validator;
        $address = $itemNormalizer->denormalize(json_decode($request->getContent(), true), Address::class, 'json');
        $errors = $validator->validate($address);
        
        $status = 201;

        if (count($errors) > 0) {
            $content = $errorNormalizer->normalize($errors);
            $status = 401;
        } else {
            $id = $request->get('id');
            if ('employee' === $request->get('type')) {
                $parent = $this->getEmployeeById($id);
            }
            $parent->addAddress($address);
            $this->em->persist($parent);
            $this->em->flush();
            $content = $itemNormalizer->normalize($address);
        }
	    $headers = [
	    	'Content-Type' => 'application/ld+json'
	    ];
        return new JsonResponse($content, $status,$headers);
    }

    /**
     * @param $id
     *
     * @return Employee|null|object
     */
    protected function getEmployeeById($id)
    {
        return $this->em->getRepository(Employee::class)->findOneBy(array('id' => $id));
    }
}
