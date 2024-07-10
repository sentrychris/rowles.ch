<?php

namespace App\Controllers;

use App\Versyx\Controller;

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
    public function index()
    {
        return $this->view('home');
    }
}
