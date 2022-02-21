<?php

namespace App\Controller\Admin;

use App\Entity\Ideogramme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class IdeogrammeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ideogramme::class;
    }

    public function configureFields(string $pageName): iterable
    {
        /** @var AdminContext $adminContext */
        $adminContext = $entity = $this->getContext();

        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('logo')->setLabel('Kanji'),
            TextField::new('signification'),
            IntegerField::new('stroke')->setLabel('Traits')->hideOnIndex(),
            TextField::new('kun')->setLabel('Lecteur kun')->hideOnIndex(),
            TextField::new('readOn')->setLabel('Lecture ON')->hideOnIndex(),
            IntegerField::new('jlpt')->setLabel('Niveau JLPT'),
            ArrayField::new('similars')->hideOnIndex()->onlyOnDetail()->setLabel('Kanji similaire'),
            ArrayField::new('examples')->hideOnIndex()->onlyOnDetail()->setLabel('Exemple de mot'),
        ];

        if (null != $adminContext) {
            /** @var Ideogramme $entity */
            $entity = $adminContext->getEntity()->getInstance();

            if ($entity instanceof \App\Entity\KanjiKey) {
                $fields = array_merge($fields, [
                    IntegerField::new('numberKey')->setLabel('Numéro de la clé')
                ]);
            }
        }

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_ADMIN')
            ->setEntityLabelInSingular('idéogramme')
            ->setEntityLabelInPlural('idéogrammes')
            ->setPageTitle('detail', 'Consulter un %entity_label_singular%')
            ->setPageTitle('index', 'La liste des %entity_label_plural%')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('logo')
            ->add('jlpt')
            ->add('stroke')
        ;
    }
}
