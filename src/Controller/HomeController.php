<?php

namespace App\Controller;

use App\Entity\Ideogramme;
use App\Handler\IdeogrammeReadHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private IdeogrammeReadHandler $ideogrammeReadHandler)
    {}

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'kanjis' => $this->ideogrammeReadHandler->getLastKanji(Ideogramme::LAST_KANJI)
        ]);
    }
}
