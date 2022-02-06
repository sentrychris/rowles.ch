<?php

namespace Rowles\Controllers\Auth;

use Klein\Request;
use Klein\Response;
use Pimple\Container;

class RegisterController extends AuthController
{
    /**
     * AuthController constructor.
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
        return $this->render('auth/register');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function submit(Request $request, Response $response): Response
    {
        $user = $this->user->setAttributes($request->params());

        if (!$user->save()) {
            $result = ['message' => 'Error creating user.', 'status' => 'error'];
        } else {
            $result = ['message' => 'User successfully created.', 'status' => 'success'];
        }

        return $response->json($result);
    }
}