<?php

namespace App\Controller\Admin;

use App\Entity\Exercice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ExerciceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.exercise')
            ->setEntityLabelInPlural('entity.exercises')
            ->setPaginatorPageSize(12);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'form.id')->hideOnForm(),
            TextField::new('description', 'form.description'),
            DateTimeField::new('date', 'form.date'),
            AssociationField::new('classe', 'form.class'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // Apply class filter if present in request
        $request = $this->container->get('request_stack')->getCurrentRequest();
        if ($request && $request->query->has('filters') && isset($request->query->all('filters')['classe']['value'])) {
            $classeId = $request->query->all('filters')['classe']['value'];
            $queryBuilder
                ->andWhere('entity.classe = :classe')
                ->setParameter('classe', $classeId);
        }

        return $queryBuilder;
    }
}
