<?php

namespace Rowles\Controllers;

use Exception;
use Klein\Request;
use Klein\Response;
use Pimple\Container;
use Rowles\Models\Blog;
use Rowles\Models\Contact;
use Rowles\Controllers\Auth\AuthController;

/**
 * Blog controller class.
 */
class ContactController extends AuthController
{
    /** @var Contact $contact */
    protected Contact $contact;

    /**
     * ContactController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->contact = new Contact($container);

        parent::__construct($container);
    }

    /**
     * View contact page.
     *
     * @return mixed
     */
    public function view()
    {
        return $this->render('contact');
    }


    /**
     * Submit a new contact request and save it to the database.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws Exception
     */
    public function submit(Request $request, Response $response): Response
    {
        $contact = $this->contact->setAttributes($request->params());
        $contact->save();
    }
}
