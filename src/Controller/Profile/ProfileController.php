<?php

namespace App\Controller\Profile;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Profile\ProfileCrudController;
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
        yield MenuItem::linkToDashboard('Profil', 'fa fa-user');
    }
}
