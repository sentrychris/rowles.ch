<?php

namespace Rowles\Controllers\Auth;

use Exception;
use Klein\Request;
use Klein\Response;
use Pimple\Container;

class LoginController extends AuthController
{
    /**
     * LoginController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * @return mixed
     */
    public function view()
    {
        return $this->render('auth/login');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function submit(Request $request, Response $response): Response
    {
        $authenticated = false;

        try {
            $authenticated = $this->user->login($request->params());
        } catch (Exception $e) {
            $this->log->error($e->getMessage());
        }

        if ($authenticated['status'] === 'error') {
            $_SESSION['message'] = $authenticated['message'];
            return $response->redirect('/login')->send();
        } else {
            $user = $authenticated['user'];
        }

        $this->session->setAttributes(['user_id' => $user['id']])->create($user);

        return $response->redirect('/')->send();
    }
}