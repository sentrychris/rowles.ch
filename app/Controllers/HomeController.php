<?php

namespace App\Controllers;

use Versyx\Controller;
use Versyx\Request;

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
    public function index(Request $request)
    {
        return $this->view('home');
    }
}
