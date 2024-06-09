<?php

namespace App\DataFixtures;

use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionnaireFixtures extends Fixture implements DependentFixtureInterface
{
    public const TEST_QUESTIONNAIRE_SLUG = 'erectile-health';

    public function load(ObjectManager $manager): void
    {
        $questionnaire = (new Questionnaire())
            ->setDescription('A short questionnaire designed to determine which product is best for you')
            ->setSlug(self::TEST_QUESTIONNAIRE_SLUG)
            ->setQuestions(new ArrayCollection([
                $this->getReference(QuestionFixtures::QUESTION_ONE),
                $this->getReference(QuestionFixtures::QUESTION_TWO),
                $this->getReference(QuestionFixtures::QUESTION_TWO_A),
                $this->getReference(QuestionFixtures::QUESTION_TWO_B),
                $this->getReference(QuestionFixtures::QUESTION_TWO_C),
                $this->getReference(QuestionFixtures::QUESTION_THREE),
                $this->getReference(QuestionFixtures::QUESTION_FOUR),
            ]));

        $manager->persist($questionnaire);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            QuestionFixtures::class,
        ];
    }
}
