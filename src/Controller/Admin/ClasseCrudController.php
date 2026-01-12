<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ClasseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classe::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.class')
            ->setEntityLabelInPlural('entity.classes')
            ->setSearchFields(['description', 'annee'])
            ->setDefaultSort(['description' => 'ASC'])
            ->setPaginatorPageSize(12);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->addCssClass('btn btn-success');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'form.id')
            ->onlyOnIndex();

        yield TextField::new('description', 'form.description')
            ->setColumns('col-md-6')
            ->setRequired(true);

        yield TextField::new('annee', 'form.year')
            ->setColumns('col-md-6')
            ->setRequired(true);

        $etudiantsCount = IntegerField::new('etudiants', 'entity.students')
            ->formatValue(function ($value) {
                return count($value);
            })
            ->onlyOnIndex();

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            yield $etudiantsCount;
        }
    }
}
