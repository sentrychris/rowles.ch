<?php

namespace Rowles\Controllers;

use Klein\Request;
use Klein\Response;
use Pimple\Container;
use Rowles\Models\User;

class AuthController extends Controller
{
    /** @var User $user */
    protected User $user;

    /**
     * AuthController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->user = new User($container);

        parent::__construct($container);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response): Response
    {
        $user = $this->user->setAttributes($request->params());

        if (!$user->save()) {
            $result = ['msg' => 'Error creating user.', 'status' => 'error'];
        } else {
            $result = ['msg' => 'User successfully created.', 'status' => 'success'];
        }

        return $response->json($result);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Exception
     */
    public function login(Request $request, Response $response): Response
    {
        $authenticated = $this->user->login($request->params());

        if (!$authenticated) {
            $result = ['msg' => 'Error authenticating.', 'status' => 'error'];
        } else {
            $result = ['msg' => 'Successfully authenticated.', 'status' => 'success'];
        }

        return $response->json($result);
    }
}