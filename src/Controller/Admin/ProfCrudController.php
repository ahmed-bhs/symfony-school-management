<?php

namespace App\Controller\Admin;

use App\Entity\Prof;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ProfCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prof::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.professor')
            ->setEntityLabelInPlural('entity.professors')
            ->setPaginatorPageSize(12);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'form.id')->hideOnForm(),
            TextField::new('nom', 'form.name'),
            TextField::new('prenom', 'form.first_name'),
            IntegerField::new('cin', 'form.cin'),
            DateTimeField::new('dateNaissance', 'form.birth_date'),
            ChoiceField::new('genre', 'form.gender')
                ->setChoices([
                    'form.male' => 'M',
                    'form.female' => 'F',
                ]),
            EmailField::new('email', 'form.email'),
            TextareaField::new('competences', 'form.skills'),
            TextField::new('adresse', 'form.address'),
            IntegerField::new('numeroTel', 'form.phone'),
            DateTimeField::new('debut', 'form.start_date'),
            DateTimeField::new('fin', 'form.end_date'),
        ];
    }
}
