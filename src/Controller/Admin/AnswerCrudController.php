<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Answer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('text'),
            IntegerField::new('position'),
            AssociationField::new('productRecommendations')->setFormTypeOption('choice_label', fn (Product $product) => $product->getName()),
            AssociationField::new('productRestrictions')->setFormTypeOption('choice_label', fn (Product $product) => $product->getName()),
        ];
    }
}
