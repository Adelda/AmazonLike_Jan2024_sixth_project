<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Gedmo\Mapping\Driver\File;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('kkk');
        yield Field::new('name')->setColumns(6);
        yield AssociationField::new('parent')->setColumns(6);
        yield FormField::addTab('col2');
        yield Field::new('slug')
            ->hideWhenCreating();
        yield TextEditorField::new('description');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('name')
                       ->add('slug');
    }
}
