<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KanaController extends AbstractController
{
    #[Route('/les-kana', name: 'kana')]
    public function index(): Response
    {
        return $this->render('kana/index.html.twig', [
            'current_page' => 'kana',
        ]);
    }
}
