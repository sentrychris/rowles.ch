<?php

namespace App\Http\Controllers\CMS;

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
        $formRoute = '/cms/employment-history/create';

        return $this->setViewData(compact('formRoute'))
            ->view('cms/employment-history/create');
    }

    /**
     * Edit employment history page.
     * 
     * @param int $id
     */
    public function edit(int $id, EntityManager $em)
    {
        $employmentHistory = $em->getRepository(EmploymentHistory::class)
            ->find($id);
        
        $formRoute = '/cms/employment-history/edit/'.$id;

        return $this->setViewData(compact('employmentHistory', 'formRoute'))
            ->view('cms/employment-history/create');
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
            ->setIsCurrent(false)
            ->setSortOrder($data['sort_order']);

        $em->persist($entity);
        $em->flush();

        return $response->redirect('/cms');
    }

    /**
     * Update
     * 
     * @param int $id
     * @param EntityManager $em
     * @param Request $request
     * @param Response $response
     */
    public function update (string $id, EntityManager $em, Request $request, Response $response)
    {
        $data = $request->body();
    
        $entity = $em->getRepository(EmploymentHistory::class)->find($id);

        $entity->setEmployer($data['employer'])
            ->setPosition($data['position'])
            ->setTime($data['time'])
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
    public function delete (int $id, EntityManager $em, Response $response)
    {
        $entity = $em->getRepository(EmploymentHistory::class)
            ->find($id);

        $em->remove($entity);
        $em->flush();

        return $response->redirect('/cms');
    }
}