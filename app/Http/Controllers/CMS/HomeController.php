<?php

namespace App\Http\Controllers\CMS;

use Doctrine\ORM\EntityManager;
use Versyx\Http\AbstractController;
use App\Entities\ContactDetail;
use App\Entities\EmploymentHistory;

/**
 * Simple content management
 */
class HomeController extends AbstractController
{
    /**
     * Index
     * 
     * @param EntityManager $em
     */
    public function index(EntityManager $em)
    {
        $employmentHistory = $em->getRepository(EmploymentHistory::class)->findAll();
        $contactDetails = $em->getRepository(ContactDetail::class)->findAll();

        return $this->view('cms/index.twig', compact('employmentHistory', 'contactDetails'));
    }
}