<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Questionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuestionnaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Questionnaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('slug'),
            TextField::new('description'),
            AssociationField::new('questions')->setFormTypeOption('choice_label', fn (Question $question) => $question->getText()),
        ];
    }
}
