<?php

namespace DietCook;

use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testIsAction()
    {
        $this->assertTrue(Controller::isAction('index'));
        $this->assertTrue(Controller::isAction('view'));

        $this->assertFalse(Controller::isAction('__construct'));
        $this->assertFalse(Controller::isAction('beforeFilter'));
        $this->assertFalse(Controller::isAction('isAction'));
        $this->assertFalse(Controller::isAction('set'));
        $this->assertFalse(Controller::isAction('render'));
    }

    public function testSet()
    {
        $controller = new Controller('');
        $controller->set('foo', 100);
        $controller->set('bar', [1, 2]);
        $this->assertEquals(100, $controller->view->vars['foo']);
        $this->assertEquals([1, 2], $controller->view->vars['bar']);

        $controller->set(['foo' => 200]);
        $this->assertEquals(200, $controller->view->vars['foo']);
    }
}
