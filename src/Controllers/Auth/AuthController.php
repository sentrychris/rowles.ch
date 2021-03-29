<?php

namespace Rowles\Controllers\Auth;

use Klein\Request;
use Klein\Response;
use Pimple\Container;
use Rowles\Models\User;
use Rowles\Models\Session;
use Rowles\Controllers\Controller;

class AuthController extends Controller
{
    /** @var User $user */
    protected User $user;

    /** @var Session $session */
    protected Session $session;

    /**
     * AuthController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->user = new User($container);
        $this->session = new Session($container);

        parent::__construct($container);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function logout(Request $request, Response $response)
    {
        $this->session->delete();
        $response->redirect('/')->send();
    }
}