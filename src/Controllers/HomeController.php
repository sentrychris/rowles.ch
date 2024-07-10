<?php

namespace Rowles\Controllers;

use Rowles\Test;

/**
 * Page controller class.
 */
class HomeController extends Controller
{
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
