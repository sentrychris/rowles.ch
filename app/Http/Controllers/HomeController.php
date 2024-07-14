<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Versyx\Session\SessionManager;
use Versyx\Http\AbstractController;
use App\Entities\EmploymentHistory;

/**
 * Home controller.
 */
class HomeController extends AbstractController
{
    /**
     * Render the home page.
     *
     * @param array $data
     * @return mixed
     */
    public function index(EntityManager $em, SessionManager $sm)
    {
        $employment = $em->getRepository(EmploymentHistory::class)
            ->findAll();

        return $this
            ->setViewData(['employment' => $employment])
            ->view('index');
    }
}
