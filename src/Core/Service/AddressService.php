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

namespace Demo\Core\Service;

use Demo\Entity\Address;
use Demo\Entity\AddressableInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ApiPlatform\Core\JsonLd\Serializer\ItemNormalizer;
use ApiPlatform\Core\Hydra\Serializer\ErrorNormalizer;

class AddressService
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
        $this->em = $doctrine->getManager();
        $this->errorNormalizer = $errorNormalizer;
        $this->itemNormalizer = $itemNormalizer;
        $this->validator = $validator;
    }

    /**
     * @param string  $ownerId
     * @param string  $ownerClass
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createNew($ownerClass, $ownerId, Request $request)
    {
        /* @var Address $address */
        /* @var AddressableInterface $parent */
        $itemNormalizer = $this->itemNormalizer;
        $errorNormalizer = $this->errorNormalizer;
        $validator = $this->validator;

        $address = $itemNormalizer->denormalize(
            json_decode($request->getContent(), true),
            Address::class
        );
        $errors = $validator->validate($address);

        $status = 201;
        if (count($errors) > 0) {
            $content = $errorNormalizer->normalize($errors);
            $status = 401;
        } else {
            $owner = $this->getAddressOwner($ownerClass, $ownerId);
            $owner->addAddress($address);
            $this->em->persist($owner);

            $this->em->flush();
            $content = $itemNormalizer->normalize($address);
        }
        $headers = array(
            'Content-Type' => 'application/ld+json',
        );

        return new JsonResponse($content, $status, $headers);
    }

    /**
     * @param $ownerClass
     * @param $id
     *
     * @return AddressableInterface
     */
    private function getAddressOwner($ownerClass, $id)
    {
        /* @var \Demo\Entity\AddressableInterface $owner */
        $repository = $this->em->getRepository($ownerClass);
        $owner = $repository->findOneBy(array('id' => $id));
        if (null === $owner) {
            throw new NotFoundHttpException('Can not find address owner for this class');
        }

        return $owner;
    }
}
