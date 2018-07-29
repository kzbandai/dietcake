<?php

namespace DietCook;

class View
{
    public $controller;
    public $vars = [];
    public static $ext = '.php';

    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    /**
     * コンテンツをレンダリングする
     * $this->render(); // 現在のコントローラ/アクションのビュー
     * $this->render('edit'); // 現在のコントローラ、edit アクションのビュー
     * $this->render('error/503'); // error コントローラ、503 アクションのビューをレンダリング
     *
     * @param string $action レンダリングするアクション名
     *
     * @return void
     * @throws DCException
     */
    public function render(?string $action = null): void
    {
        $action = $action ?? $this->controller->action;
        if (strpos($action, '/') === false) {
            $view_filename = VIEWS_DIR . $this->controller->name . '/' . $action . static::$ext;
        } else {
            $view_filename = VIEWS_DIR . $action . static::$ext;
        }
        $content = static::extract($view_filename, $this->vars);
        $this->controller->output .= $content;
    }

    /**
     * @param string $filename
     * @param        $vars
     *
     * @return string
     * @throws DCException
     */
    public static function extract(string $filename, array $vars): string
    {
        if (!file_exists($filename)) {
            throw new DCException("{$filename} is not found");
        }

        extract($vars, EXTR_SKIP);
        ob_start();
        ob_implicit_flush(0);
        include $filename;

        return ob_get_clean();
    }
}
