<?php

namespace DietCook;

use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testSet()
    {
        $model = new Model;
        $model->set(['foo' => 200, 'bar' => 'test']);
        $this->assertEquals(200, $model->foo);
        $this->assertEquals('test', $model->bar);
    }

    public function testValidate()
    {
        require_once __DIR__ . '/globalnamespace/TestPlayer.php';
        $test_player = new \TestPlayer;
        $test_player->name = '';
        $this->assertFalse($test_player->validate());
        $this->assertTrue($test_player->hasError());

        $test_player->name = 'aa';
        $this->assertFalse($test_player->validate());
        $this->assertTrue($test_player->hasError());

        $test_player->name = 'aaa';
        $this->assertTrue($test_player->validate());
        $this->assertFalse($test_player->hasError());

        $test_player->name = '0123456789123456';
        $this->assertTrue($test_player->validate());
        $this->assertFalse($test_player->hasError());

        $test_player->name = '01234567891234567';
        $this->assertFalse($test_player->validate());
        $this->assertTrue($test_player->hasError());
    }
}
