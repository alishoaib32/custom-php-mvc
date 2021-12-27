<?php

namespace system;

/**
 * View Class
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view The view file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        $header_file = dirname(__DIR__) . "/app/views/common/header.php";
        $footer_file = dirname(__DIR__) . "/app/views/common/footer.php";
        $file = dirname(__DIR__) . "/app/views/$view";

        if (is_readable($file)) {
            if (file_exists($header_file) && is_readable($header_file)) {
                require_once $header_file;
            }

            require_once $file;

            if (file_exists($footer_file) && is_readable($footer_file))
                require_once $footer_file;

        } else {
            throw new \Exception("$file not found");
        }
    }


}