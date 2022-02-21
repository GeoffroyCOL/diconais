<?php

namespace App\Controller\Profile;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_DETAIL, Action::INDEX)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnDetail(),
            TextField::new('username')->setLabel('Pseudo')->hideOnForm(),
            TextField::new('email')->setLabel('Adresse email'),
            TextField::new('plainPassword')
                ->setLabel('Modifier votre mot de passe')
                ->onlyWhenUpdating()
                ->setHelp('Le mot de passe doit contenir au minimum 6 caractères, une majuscule, un nombre et une minuscule')
            ,
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_ADMIN')
            ->setEntityLabelInSingular('profil')
            ->setPageTitle('detail', 'Mon %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier mon %entity_label_singular%')
        ;
    }
}
