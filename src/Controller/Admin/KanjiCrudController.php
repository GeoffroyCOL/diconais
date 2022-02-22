<?php

namespace App\Controller\Admin;

use App\Entity\Kanji;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\IdeogrammeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class KanjiCrudController extends IdeogrammeCrudController
{
    public static function getEntityFqcn(): string
    {
        return Kanji::class;
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
            ->setEntityLabelInSingular('kanji')
            ->setEntityLabelInPlural('kanjis')
            ->setPageTitle('detail', 'Consulter un %entity_label_singular%')
            ->setPageTitle('index', 'La liste des %entity_label_plural%')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->setPageTitle('edit', 'Modifier %entity_label_singular%')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var array $fields */
        $fields = parent::configureFields($pageName);

        return array_merge($fields, [
            AssociationField::new('kanjiKey')->setLabel('Clé')->hideOnIndex()->setColumns('col-md-6')
        ]);
    }
}
