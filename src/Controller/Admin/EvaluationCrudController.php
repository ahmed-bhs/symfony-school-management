<?php

namespace App\Controller\Admin;

use App\Entity\Evaluation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvaluationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evaluation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.evaluation')
            ->setEntityLabelInPlural('entity.evaluations')
            ->setPaginatorPageSize(12);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'form.id')->hideOnForm(),
            TextField::new('description', 'form.description'),
            TextField::new('semestre', 'form.semester'),
            NumberField::new('coef', 'form.coefficient')->setNumDecimals(2),
            DateTimeField::new('date', 'form.date'),
            AssociationField::new('classe', 'form.class'),
            AssociationField::new('prof', 'form.professor'),
        ];
    }
}
