<?php

namespace App\Controller\Admin;

use App\Form\ImageType;
use App\Entity\Ideogramme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            4 => IdField::new('id')->hideOnForm(),
            1 => TextField::new('logo')->setLabel('Kanji'),
            2 => TextField::new('signification'),
            3 => IntegerField::new('stroke')->setLabel('Traits')->hideOnIndex(),
            0 => TextField::new('kun')->setLabel('Lecteur kun')->hideOnIndex(),
            5 => TextField::new('readOn')->setLabel('Lecture ON')->hideOnIndex(),
            6 => IntegerField::new('jlpt')->setLabel('Niveau JLPT'),
            7 => ArrayField::new('similars')->hideOnIndex()->onlyOnDetail()->setLabel('Kanji similaire'),
            8 => ArrayField::new('examples')->hideOnIndex()->onlyOnDetail()->setLabel('Exemple de mot'),
            9 => ImageField::new('image')
                ->hideOnIndex()
                ->hideWhenCreating()
                ->setUploadDir('public/uploads/ideogrammes')
                ->setBasePath('uploads/ideogrammes')
                ->setFormType(ImageType::class),
            11 => TextField::new('image')
                ->setFormType(ImageType::class)->onlyOnForms(),
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
