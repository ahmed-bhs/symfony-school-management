<?php

namespace App\Controller\Admin;

use App\Entity\Note;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class NoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Note::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.grade')
            ->setEntityLabelInPlural('entity.grades')
            ->setPaginatorPageSize(12);
    }

    public function configureActions(Actions $actions): Actions
    {
        // Créer l'action personnalisée pour la saisie rapide
        $massGradeEntry = Action::new('massGradeEntry', 'menu.mass_grade_entry', 'fa fa-edit')
            ->linkToRoute('admin_mass_grade_select_class')
            ->setCssClass('btn btn-success')
            ->createAsGlobalAction();

        return $actions
            ->add(Crud::PAGE_INDEX, $massGradeEntry)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->addCssClass('btn btn-primary');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'form.id')->hideOnForm(),
            AssociationField::new('etudiant', 'form.student'),
            AssociationField::new('evaluation', 'form.evaluation'),
            AssociationField::new('classe', 'form.class'),
            NumberField::new('valeur', 'form.grade_value')->setNumDecimals(2),
        ];
    }
}
