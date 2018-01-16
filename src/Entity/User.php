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

namespace Omed\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User.
 *
 * @ORM\Entity()
 * @ORM\Table(name="security_users")
 * @ApiResource(
 *     attributes={
 *         {"access_control"="is_granted('ROLE_USER')"}
 *     },
 *     collectionOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"method"="POST","access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"method"="GET","access_control"="is_granted('ROLE_ADMIN')"},
 *         "put"={"method"="PUT","access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 */
class User extends BaseUser
{
    /**
     * @var null|int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
