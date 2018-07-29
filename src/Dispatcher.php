<?php

namespace DietCook;

class Dispatcher
{
    public const DC_ACTION = 'dc_action';

    /**
     * @throws DCException
     * @throws \ReflectionException
     */
    public static function invoke()
    {
        [$controller_name, $action_name] = static::parseAction(Param::get(DC_ACTION));

        $controller = static::getController($controller_name);

        $controller->action = $action_name;
        $controller->beforeFilter();
        $controller->dispatchAction();
        $controller->afterFilter();

        echo $controller->output;
    }

    /**
     * URL MUST be http://example.com/index.php?dc_action=controller-name/action-name
     *
     * @param string $dc_action
     *
     * @return array
     * @throws DCException
     */
    public static function parseAction(string $dc_action): array
    {
        $action = explode('/', $dc_action);

        if (\count($action) < 2) {
            throw new DCException('invalid url format');
        }
        $action_name = array_pop($action);
        $controller_name = implode('_', $action);

        return [$controller_name, $action_name];
    }

    /**
     * @param string $controller_name
     *
     * @return Controller
     * @throws DCException
     */
    public static function getController($controller_name): Controller
    {
        $controller_class = Inflector::camelize($controller_name) . 'Controller';

        if (!class_exists($controller_class)) {
            throw new DCException("{$controller_class} is not found");
        }

        return new $controller_class($controller_name);
    }
}
