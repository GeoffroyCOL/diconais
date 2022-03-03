<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeogrammeController extends AbstractController
{
    #[Route('/histoire', name: 'ideogramme')]
    public function index(): Response
    {
        return $this->render('ideogramme/index.html.twig');
    }
}
