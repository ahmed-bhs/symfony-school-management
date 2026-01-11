<?php

namespace App\Controller\Admin;

use App\Entity\Prof;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prof::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            IntegerField::new('cin', 'CIN'),
            DateTimeField::new('dateNaissance', 'Date de naissance'),
            TextField::new('genre', 'Genre'),
            EmailField::new('email', 'Email'),
            TextareaField::new('competences', 'Compétences'),
            TextField::new('adresse', 'Adresse'),
            IntegerField::new('numeroTel', 'Numéro de téléphone'),
            DateTimeField::new('debut', 'Date de début'),
            DateTimeField::new('fin', 'Date de fin'),
        ];
    }
}
