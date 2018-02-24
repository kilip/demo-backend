<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Omed\Core\Test;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\Assert;

trait MutableTest
{
    protected $entity;

    protected $mutableClassToTest;

    protected $mutableTestConfig = array();

    protected $propertyToIgnores = array();

    /**
     * @dataProvider getTestMutablePropertiesDataProvider
     */
    public function testMutableProperties($property, $readOnly = false, $testValue = 'some_value', $default = null)
    {
        if (!is_object($this->entity)) {
            $class = $this->getClassToTest();
            $this->entity = new $class();
        }
        $entity = $this->entity;

        $setter = array($entity, 'set'.$property);
        $getter = array($entity, 'get'.$property);
        $isMethod = array($entity, 'is'.$property);
        if (!is_callable($getter)) {
            if (is_callable($isMethod)) {
                $getter = $isMethod;
            } else {
                throw new ExpectationFailedException('Getter is not callable');
            }
        }

        if ($readOnly) {
            Assert::assertEquals(
                $default,
                call_user_func($getter),
                sprintf('Default value for "%s" is not set.', $property)
            );

            return;
        }
        if (!is_callable($setter)) {
            throw new ExpectationFailedException('Setter is not callable');
        }

        $num = func_get_args();
        if (count($num) > 3) {
            Assert::assertEquals(
                $default,
                call_user_func($getter),
                'Default value is not set to "'.$default.'"'
            );
        }

        call_user_func($setter, $testValue);
        $getValue = call_user_func($getter);
        Assert::assertEquals(
            $testValue, $getValue, 'Failed to get'
        );

        if (is_callable($isMethod)) {
            Assert::assertEquals(
                $testValue, call_user_func($isMethod), sprintf('Failed to get with is%s', $property)
            );
        }
    }

    public function getTestMutablePropertiesDataProvider()
    {
        return $this->generatePropertyToTest();
    }

    final protected function generatePropertyToTest()
    {
        $this->configureMutablePropertiesTest();
        $r = new \ReflectionClass($this->getClassToTest());
        $properties = $r->getProperties();
        $data = array();
        $config = $this->mutableTestConfig;
        $ignores = $this->propertyToIgnores;
        foreach ($properties as $key => $property) {
            $name = $property->getName();
            if ($this->getClassToTest() != $property->getDeclaringClass()->getName()) {
                continue;
            }
            if (in_array($name, $ignores)) {
                continue;
            }
            $testValue = 'some value';
            $readOnly = false;
            $default = null;

            if ('created' == $name || 'updated' == $name) {
                $testValue = new \DateTime();
                $readOnly = true;
            }

            $tpl = array(
                'name' => $name,
                'readonly' => $readOnly,
                'value' => $testValue,
            );

            if ('id' == $name) {
                $tpl['readonly'] = true;
                unset($tpl['value']);
                unset($tpl['default']);
            }

            if (isset($config[$name])) {
                $tpl = array_merge($tpl, $config[$name]);
            }

            $data[] = $tpl;
        }

        return $data;
    }

    protected function configureMutablePropertiesTest()
    {
    }

    protected function getClassToTest()
    {
        $classToTest = strtr(__CLASS__, array(
            '\Tests' => '',
            'Tests' => '',
        ));
        $classToTest = str_replace('Test', '', $classToTest);
        //$classToTest = rtrim($classToTest,'Test');

        if (!class_exists($classToTest)) {
            throw new ExpectationFailedException(
                sprintf('Can not test mutable properties. Class "%s" not exists.', $classToTest)
            );
        }

        return $classToTest;
    }
}
