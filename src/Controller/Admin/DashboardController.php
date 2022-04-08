<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Kanji;
use App\Entity\KanjiKey;
use App\Entity\Ideogramme;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProfileCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        /** @var User $user  */
        $user = $this->getUser();

        return $this->redirect(
            $this->adminUrlGenerator
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

            MenuItem::linkToUrl('Retour vers le site', 'fa fa-reply-all', '/'),

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

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $url = $this->adminUrlGenerator
            ->setController(ProfileCrudController::class)
            ->setEntityId($user->getId()) /** @phpstan-ignore-line */
            ->setAction(Action::DETAIL)
        ;

        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->addMenuItems([MenuItem::linkToUrl('Mon profil', 'fa fa-id-card', $url)]);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(15)
            ->setEntityPermission('ROLE_ADMIN')
        ;
    }
}
