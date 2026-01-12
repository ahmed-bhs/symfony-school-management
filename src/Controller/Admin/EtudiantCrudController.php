<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class EtudiantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('entity.student')
            ->setEntityLabelInPlural('entity.students')
            ->setSearchFields(['nom', 'prenom', 'adresse', 'nomPere', 'nomMere'])
            ->setDefaultSort(['nom' => 'ASC'])
            ->setPaginatorPageSize(12)
            ->setEntityPermission('ROLE_ADMIN');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->addCssClass('btn btn-success');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash');
            });
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('classe', 'form.class'))
            ->add(BooleanFilter::new('status', 'form.status'))
            ->add(ChoiceFilter::new('genre', 'form.gender')->setChoices([
                'form.male' => 'M',
                'form.female' => 'F',
            ]));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'form.id')
            ->onlyOnIndex();

        yield TextField::new('nom', 'form.name')
            ->setColumns('col-md-6')
            ->setRequired(true);

        yield TextField::new('prenom', 'form.first_name')
            ->setColumns('col-md-6')
            ->setRequired(true);

        yield DateField::new('dateNaissance', 'form.birth_date')
            ->setColumns('col-md-6')
            ->setRequired(true)
            ->setFormTypeOption('years', range(date('Y') - 25, date('Y')));

        yield ChoiceField::new('genre', 'form.gender')
            ->setColumns('col-md-6')
            ->setChoices([
                'form.male' => 'M',
                'form.female' => 'F',
            ])
            ->setRequired(true)
            ->renderAsBadges([
                'M' => 'primary',
                'F' => 'danger',
            ]);

        yield TextareaField::new('adresse', 'form.address')
            ->setColumns('col-md-12')
            ->hideOnIndex();

        yield TextField::new('nomPere', 'form.father_name')
            ->setColumns('col-md-6')
            ->hideOnIndex();

        yield TextField::new('nomMere', 'form.mother_name')
            ->setColumns('col-md-6')
            ->hideOnIndex();

        yield IntegerField::new('numeroTel', 'form.phone')
            ->setColumns('col-md-6');

        yield BooleanField::new('status', 'form.status')
            ->setColumns('col-md-6')
            ->renderAsSwitch(true);

        yield AssociationField::new('classe', 'form.class')
            ->setColumns('col-md-6')
            ->setRequired(true)
            ->autocomplete();
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

