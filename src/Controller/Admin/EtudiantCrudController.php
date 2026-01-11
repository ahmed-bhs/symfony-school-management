<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtudiantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            DateField::new('dateNaissance', 'Date de naissance'),
            TextField::new('genre', 'Genre'),
            TextField::new('adresse', 'Adresse'),
            TextField::new('nomPere', 'Nom du père'),
            TextField::new('nomMere', 'Nom de la mère'),
            IntegerField::new('numeroTel', 'Numéro de téléphone'),
            BooleanField::new('status', 'Actif'),
            AssociationField::new('classe', 'Classe'),
        ];
    }
}
