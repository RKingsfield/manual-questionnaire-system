<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('text'),
            IntegerField::new('position'),
            AssociationField::new('answersRequiredToDisplay')->setFormTypeOption('choice_label', fn (Answer $answer) => $answer->getText()),
            AssociationField::new('answers')->setFormTypeOption('choice_label', fn (Answer $answer) => $answer->getText()),
        ];
    }
}
