<?php

namespace App\Controller\Admin;

use App\Entity\Arrivages;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArrivagesCrudController extends AbstractCrudController

{
    public static function getEntityFqcn(): string
    {
        return Arrivages::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Listes des arrivages')
            ->setEntityLabelInSingular('Liste des arrivages')

            ->setPageTitle("index", "GarageVP - Administration des Arrivages")
            ->setPaginatorPageSize('10')
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            idField::new('id')
                ->hideOnForm(),
            TextField::new('marque'),
            TextField::new('model'),
            TextareaField::new('property')
                ->setFormType(CKEditorType::class),
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->setFormTypeOption('disabled', 'disabled'),


        ];
    }
}
