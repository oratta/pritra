<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param $className
     * @param $methodName
     * @return \ReflectionMethod
     */
    protected function setAccessable($className, $methodName)
    {
        $reflection = new \ReflectionClass($className);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

    public function setUp() : void
    {
        parent::setUp();

        $uses = array_flip(class_uses_recursive(static::class));
        if(isset($uses[SeedingDatabase::class])){
            $this->seedingDatabase();
        }
    }
}
