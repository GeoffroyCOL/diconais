<?php

namespace App\Controller;

use App\Data\FilterData;
use App\Form\FilterType;
use App\Entity\Ideogramme;
use App\Handler\IdeogrammeReadHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdeogrammeController extends AbstractController
{
    public function __construct(private IdeogrammeReadHandler $ideogrammeReadHandler)
    {}

    #[Route('/histoire', name: 'ideogramme.history')]
    public function index(): Response
    {
        return $this->render('ideogramme/index.html.twig', [
            'current_page' => 'histoire',
            'page_title' => 'Histoire'
        ]);
    }

    #[Route('/les-kanji', name: 'ideogramme.list')]
    public function listKanji(Request $request): Response
    {
        $data = new FilterData();
        $data->page = $request->query->getInt('page', 1);

        $form = $this->createForm(FilterType::class, $data);
        $form->handleRequest($request);

        $ideogrammes = $this->ideogrammeReadHandler->getSearch($data);

        return $this->renderForm('ideogramme/list-kanji.html.twig', [
            'ideogrammes' => $ideogrammes,
            'form' => $form,
            'current_page' => 'kanji',
            'page_title' => 'Les kanji'
        ]);
    }

    #[Route('/kanji/{id}', name: 'ideogramme.show', requirements: ['id' => '\d+'])]
    public function showKanji(Ideogramme $ideogramme): Response
    {
        return $this->render('ideogramme/show-kanji.html.twig', [
            'ideogramme' => $ideogramme,
            'current_page' => 'kanji',
            'logo' => $ideogramme->getLogo(),
            'signification' => $ideogramme->getSignification()
        ]);
    }
}
