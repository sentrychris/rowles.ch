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

        return $this->view('cms/index.twig', compact('contactDetails'));
    }

    /**
     * Create new contact detail page.
     */
    public function create()
    {
        $formRoute = '/cms/contact-detail/create';

        return $this->view('cms/contact-detail/create', compact('formRoute'));
    }

    /**
     * Edit contact detail page.
     */
    public function edit(int $id, EntityManager $em)
    {
        $contactDetail = $em->getRepository(ContactDetail::class)
            ->find($id);

        $formRoute = '/cms/contact-detail/edit/'.$id;

        return $this->view('cms/contact-detail/create', compact('contactDetail', 'formRoute'));
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
            ->setText($data['text'])
            ->setSortOrder($data['sort_order']);

        $em->persist($entity);
        $em->flush();

        return $response->redirect('/cms');
    }

    /**
     * Update
     * 
     * @param EntityManager $em
     * @param Request $request
     * @param Response $response
     */
    public function update (int $id, EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();

        $entity = $em->getRepository(ContactDetail::class)->find($id);
    
        $entity->setTitle($data['title'])
            ->setLink($data['link'])
            ->setText($data['text'])
            ->setSortOrder($data['sort_order']);

        $em->persist($entity);
        $em->flush();

        return $response->redirect('/cms');
    }

    /**
     * Delete
     * 
     * @param int $id
     * @param EntityManager $em
     * @param Response $response
     */
    public function delete(int $id, EntityManager $em, Response $response)
    {
        $entity = $em->getRepository(ContactDetail::class)
            ->find($id);

        $em->remove($entity);
        $em->flush();

        return $response->redirect('/cms');
    }
}