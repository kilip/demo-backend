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

namespace Omed\Resource\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * Class Group.
 *
 * @ORM\Entity()
 * @ORM\Table(name="security_groups")
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
class Group extends BaseGroup
{
    /**
     * @var null|int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
