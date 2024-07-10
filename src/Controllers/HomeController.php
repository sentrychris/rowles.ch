<?php

namespace Rowles\Controllers;

use Rowles\Test;

/**
 * Page controller class.
 */
class HomeController extends Controller
{
    /** @var Test */
    private Test $test;

    /**
     * HomeController constructor.
     *
     * @param Container $container
     */
    public function __construct(Test $test)
    {
        parent::__construct();
        $this->test = $test;
    }

    /**
     * Render the home page.
     *
     * @param array $data
     * @return mixed
     */
    public function index(array $data = [])
    {
        $this->test->do();
        return $this->setViewData($data)->render('home');
    }
}
