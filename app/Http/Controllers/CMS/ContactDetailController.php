<?php

namespace App\Http\Controllers\CMS;

use Doctrine\ORM\EntityManager;
use Versyx\Http\AbstractController;
use Versyx\Http\Request;
use Versyx\Http\Response;
use App\Entities\ContactDetail;

/**
 * Simple content management
 */
class ContactDetailController extends AbstractController
{
    /**
     * Index
     * 
     * @param EntityManager $em
     */
    public function index(EntityManager $em)
    {
        $contactDetails = $em->getRepository(ContactDetail::class)->findAll();

        return $this->setViewData(compact('contactDetails'))
            ->view('cms/index.twig');
    }

    /**
     * Create new contact detail page.
     */
    public function create()
    {
        return $this->view('cms/contact-detail/create');
    }

    /**
     * Store
     * 
     * @param EntityManager $em
     * @param Request $request
     * @param Response $response
     */
    public function store(EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();

        $em->getRepository(ContactDetail::class);
    
        $entity = new ContactDetail();
        $entity->setTitle($data['title'])
            ->setLink($data['link'])
            ->setText($data['text']);

        $em->persist($entity);
        $em->flush();

        return $response->redirect('/cms');
    }

    /**
     * Delete
     * 
     * @param EntityManager $em
     * @param Request $request
     * @param Response $response
     */
    public function delete(EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();

        $entity = $em->getRepository(ContactDetail::class)
            ->find($data['id']);

        $em->remove($entity);
        $em->flush();

        return $response->redirect('/cms');
    }
}