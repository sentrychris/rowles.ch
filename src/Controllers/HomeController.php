<?php

namespace Rowles\Controllers;

use Pimple\Container;

/**
 * Page controller class.
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * Render the home page.
     *
     * @param array $data
     * @return mixed
     */
    public function home(array $data = [])
    {
        return $this->setViewData($data)->render('home');
    }
}
