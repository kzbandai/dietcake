<?php

namespace DietCook;

use PHPUnit\Framework\TestCase;

class ParamTest extends TestCase
{
    protected function setUp()
    {
        require_once __DIR__ . '/globalnamespace/functions.php';
    }

    public function testGet()
    {
        $_REQUEST['foo'] = 200;
        $this->assertEquals(200, Param::get('foo'));

        $_REQUEST['foo'] = ['a', 'b'];
        $this->assertEquals(['a', 'b'], Param::get('foo'));

        $this->assertTrue(is_null(Param::get('bar')));

        $this->assertEquals('default', Param::get('bar', 'default'));
    }

    public function testParams()
    {
        $_REQUEST = [];

        $this->assertEquals([], Param::params());

        $_REQUEST['foo'] = 100;
        $this->assertEquals(['foo' => 100], Param::params());
    }
}
