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

namespace Demo\Test\Entity;

use Demo\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    use MutableTest;

    protected function configureMutablePropertiesTest()
    {
        $this->mutableTestConfig = array(
            'id' => array(
                'value' => 1,
            ),
        );
    }
}
