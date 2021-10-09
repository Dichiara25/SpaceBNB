<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeOwnerController extends AbstractController
{
    /**
     * @Route("/frontoffice/owner", name="frontoffice_owner")
     */
    public function index(): Response
    {
        return $this->render('frontoffice_owner/index.html.twig', [
            'controller_name' => 'FrontofficeOwnerController',
        ]);
    }
}
