<?php

namespace App\Controller\Admin;

use App\Entity\KanjiKey;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\IdeogrammeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class KanjiKeyCrudController extends IdeogrammeCrudController
{
    public static function getEntityFqcn(): string
    {
        return KanjiKey::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_ADMIN')
            ->setEntityLabelInSingular('clé')
            ->setEntityLabelInPlural('clés')
            ->setPageTitle('detail', 'Consulter une %entity_label_singular%')
            ->setPageTitle('index', 'La liste des %entity_label_plural%')
        ;
    }
}
