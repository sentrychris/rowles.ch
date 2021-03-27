<?php

namespace Rowles\Controllers;

use Pimple\Container;

/**
 * Abstract base controller class.
 */
abstract class Controller
{
    /** @var mixed $log */
    protected $log;

    /** @var mixed $db */
    protected $db;

    /** @var mixed $router */
    protected $router;

    /** @var mixed $view */
    protected $view;

    /** @var array $data */
    public array $data = [];

    /**
     * Abstract Controller constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->log = $container['log'];
        $this->db = $container['db'];
        $this->router = $container['router'];
        $this->view = $container['view'];

        $this->data['title'] = env("APP_NAME");
    }

    /**
     * Set data to pass to the view.
     *
     * @param array $data
     * @return self
     */
    protected function setViewData(array $data = []) : self
    {
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if ($key === 'title' && $val !== '') {
                    $val = $val . ' | ' . $this->data['title'];
                }
                $this->data[$key] = $val;
            }
        }

        return $this;
    }

    /**
     * Renders templates with view data.
     *
     * @param string $template
     * @param array  $data
     * @return mixed
     */
    protected function render(string $template)
    {
        $template = $this->getTemplate($template);

        return $this->view->render($template, $this->data);
    }

    /**
     * Get template.
     *
     * @param string $template
     * @return string
     */
    private function getTemplate(string $template)
    {
        if(strpos($template, '.twig') === false) {
            return $template.'.twig';
        }

        return $template;
    }
}
