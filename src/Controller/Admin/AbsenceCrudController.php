<?php

namespace App\Controller\Admin;

use App\Entity\Absence;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class AbsenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Absence::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.absence')
            ->setEntityLabelInPlural('entity.absences')
            ->setPaginatorPageSize(12);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'form.id')->hideOnForm(),
            AssociationField::new('etudiant', 'form.student'),
            IntegerField::new('nombre', 'form.number_of_days'),
        ];
    }
}
