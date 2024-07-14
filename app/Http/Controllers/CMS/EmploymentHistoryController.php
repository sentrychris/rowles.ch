<?php

namespace App\Controllers\CMS;

use Doctrine\ORM\EntityManager;
use Versyx\Http\AbstractController;
use Versyx\Http\Request;
use Versyx\Http\Response;
use App\Entities\EmploymentHistory;

/**
 * Simple content management
 */
class EmploymentHistoryController extends AbstractController
{
    /**
     * Index
     * 
     * @param EntityManager $em
     */
    public function index (EntityManager $em)
    {
        $employmentHistory = $em->getRepository(EmploymentHistory::class)->findAll();

        return $this->setViewData(compact('employmentHistory'))
            ->view('cms/index.twig');
    }

    /**
     * Create new employment history page.
     */
    public function create()
    {
        return $this->view('cms/employment-history/create');
    }

    /**
     * Store
     * 
     * @param EntityManager $em
     * @param Request $request
     * @param Response $response
     */
    public function store (EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();

        $em->getRepository(EmploymentHistory::class);
    
        $entity = new EmploymentHistory();
        $entity->setEmployer($data['employer'])
            ->setPosition($data['position'])
            ->setTime($data['time'])
            ->setIsCurrent(false);

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
    public function delete (EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();

        $entity = $em->getRepository(EmploymentHistory::class)
            ->find($data['id']);

        $em->remove($entity);
        $em->flush();

        return $response->redirect('/cms');
    }
}