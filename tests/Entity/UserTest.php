<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Test\Entity;

use Omed\Test\MutableTest;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use MutableTest;

    protected function configureMutablePropertiesTest()
    {
        $this->propertyToIgnores = array();
    }
}
