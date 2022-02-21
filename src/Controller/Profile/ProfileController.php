<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Entity\Kanji;
use App\Entity\KanjiKey;
use App\Entity\Ideogramme;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\KanjiCrudController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Profile\ProfileCrudController;
use App\Controller\Admin\IdeogrammeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class ProfileController extends AbstractDashboardController
{
    public function __construct(private Security $security)
    {}

    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();

        /** @var AdminUrlGenerator $adminUrlGenerator */
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect(
            $adminUrlGenerator
                ->setController(ProfileCrudController::class)
                ->setEntityId($user->getId())
                ->setAction(Action::DETAIL)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Diconais');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Idéogrammes'),
            MenuItem::linkToCrud('La liste complète', 'fa fa-file-text', Ideogramme::class),

            MenuItem::section('Les kanji'),
            MenuItem::linkToCrud('Voir la liste', 'fa fa-file-text', Kanji::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Kanji::class)->setAction(ACTION::NEW),

            MenuItem::section('Les clés'),
            MenuItem::linkToCrud('Voir la liste', 'fa fa-file-text', KanjiKey::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', KanjiKey::class)->setAction(ACTION::NEW),
        ];
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(15)
            ->setEntityPermission('ROLE_ADMIN')
        ;
    }
}
