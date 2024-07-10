<?php

namespace Rowles\Controllers;

use Pimple\Container;
use Psr\Log\LoggerInterface;
use Twig\Environment;

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
    public function __construct(LoggerInterface $logger, Environment $view)
    {
        parent::__construct($logger, $view);
    }

    /**
     * Render the home page.
     *
     * @param array $data
     * @return mixed
     */
    public function index(array $data = [])
    {
        return $this->setViewData($data)->render('home');
    }
}
