<?php

namespace Spec\Omed\Core\Service;

use Omed\Core\Service\AddressService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use Omed\Resource\Entity\Address;
use Omed\Resource\Entity\Employee;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AddressService::class);
    }

    public function let(
        ManagerRegistry $doctrine,
        EntityManagerInterface $manager,
        ObjectRepository $repository,
        NormalizerInterface $errorNormalizer,
        AbstractItemNormalizer $itemNormalizer,
        ValidatorInterface $validator
    ) {
        $doctrine
            ->getManager()
            ->willReturn($manager)
        ;
        $manager->getRepository(Employee::class)
                ->willReturn($repository)
        ;
        $this->beConstructedWith($doctrine, $errorNormalizer, $itemNormalizer, $validator);
    }

    public function it_should_add_new_address(
        $repository,
        Address $address,
        $itemNormalizer,
        Employee $employee,
        Request $request,
        ManagerRegistry $manager,
        ConstraintViolationListInterface $errorNormalizer,
        ValidatorInterface $validator
    ) {
        $requestContent = '{"some":"value"}';

        $request->getContent()
                ->shouldBeCalled()
                ->willReturn($requestContent)
        ;

        $itemNormalizer
            ->denormalize(json_decode($requestContent, true), Address::class)
            ->shouldBeCalled()
            ->willReturn($address)
        ;
        $repository
            ->findOneBy(['id' => 1])
            ->shouldBeCalled()
            ->willReturn($employee)
        ;

        $employee->addAddress($address)
                    ->shouldBeCalled()
                    ->willReturn($employee)
        ;
        $manager->persist($employee)
                ->shouldBeCalled()
        ;
        $manager->flush()->shouldBeCalled();
        $itemNormalizer->normalize($address)
                        ->shouldBeCalled()
                        ->willReturn('check-value')
        ;

        $validator->validate($address)
                    ->shouldBeCalled()
                    ->willReturn([])
        ;
        $response = $this->createNew(Employee::class, 1, $request);
        $response->shouldHaveType(JsonResponse::class);
        $response->getContent()->shouldBe(json_encode('check-value'));

        // check error
        $error = ['some' => 'error'];
        $validator->validate($address)
                    ->shouldBeCalled()
                    ->willReturn($error)
        ;
        $errorNormalizer->normalize($error)
                        ->shouldBeCalled()
                        ->willReturn($error)
        ;
        $response = $this->createNew(Employee::class, 1, $request);
        $response->shouldHaveType(JsonResponse::class);
        $response->getContent()->shouldBe(json_encode($error));
    }

    public function it_should_throw_not_found_http_exception_when_owner_not_exists(
        $repository,
        Request $request,
        $validator
    ) {
        $validator->validate(Argument::any())
            ->shouldBeCalled()
            ->willReturn([])
        ;
        $request->getContent()->willReturn('{"some":"value"}');
        $repository->findOneBy(['id' => 2])
                    ->shouldBeCalled()
                    ->willReturn(null)
        ;
        $this->shouldThrow(NotFoundHttpException::class)
                ->duringCreateNew(Employee::class, 2, $request)
        ;
    }
}
