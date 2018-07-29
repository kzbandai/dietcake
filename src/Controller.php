<?php

namespace DietCook;

class Controller
{
    public $name;
    public $action;
    /** @var View $view */
    public $view;
    public $default_view_class = View::class;
    public $output;

    public function __construct($name)
    {
        $this->name = $name;
        $this->view = new $this->default_view_class($this);
    }

    public function beforeFilter()
    {
    }

    public function afterFilter()
    {
    }

    /**
     * @throws DCException
     * @throws \ReflectionException
     */
    public function dispatchAction()
    {
        if (!static::isAction($this->action)) {
            throw new DCException('invalid action name');
        }

        if (!method_exists($this, '__call')) {
            if (!method_exists($this, $this->action)) {
                throw new DCException(sprintf('Action "%s::%s()" does not exist', \get_class($this), $this->action));
            }
            $method = new \ReflectionMethod($this, $this->action);
            if (!$method->isPublic()) {
                throw new DCException('action is not public');
            }
        }

        $this->{$this->action}();

        $this->render();
    }

    public static function isAction(string $action): bool
    {
        $methods = get_class_methods(self::class);

        return !\in_array($action, $methods, true);
    }

    public function set($name, $value = null): void
    {
        if (\is_array($name)) {
            foreach ($name as $k => $v) {
                $this->view->vars[$k] = $v;
            }
        } else {
            $this->view->vars[$name] = $value;
        }
    }

    public function beforeRender()
    {
    }

    /**
     * @param null|string $action
     *
     * @throws DCException
     */
    public function render(?string $action = null)
    {
        static $is_rendered = false;

        if ($is_rendered) {
            return;
        }

        $this->beforeRender();
        $this->view->render($action);
        $is_rendered = true;
    }
}
