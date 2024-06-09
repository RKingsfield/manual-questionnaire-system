<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUESTION_ONE = 'question-one';
    public const QUESTION_TWO = 'question-two';
    public const QUESTION_TWO_A = 'question-two-a';
    public const QUESTION_TWO_B = 'question-two-b';
    public const QUESTION_TWO_C = 'question-two-c';
    public const QUESTION_THREE = 'question-three';
    public const QUESTION_FOUR = 'question-four';

    public function load(ObjectManager $manager): void
    {
        /** ANSWERS */
        $silde100 = $this->getReference(ProductFixtures::PROD_SILDE_100);
        $silde50 = $this->getReference(ProductFixtures::PROD_SILDE_50);
        $tadal10 = $this->getReference(ProductFixtures::PROD_TADAL_10);
        $tadal20 = $this->getReference(ProductFixtures::PROD_TADAL_20);
        $allProducts = [$silde100, $silde50, $tadal10, $tadal20];

        $questionOneAnswerYes = (new Answer())
          ->setText('Yes')
          ->setPosition(0);
        $questionOneAnswerNo = (new Answer())
          ->setText('No')
          ->setPosition(1)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionOneAnswers = [$questionOneAnswerYes, $questionOneAnswerNo];

        $questionTwoAnswerOne = (new Answer())
          ->setText('Viagra or Sildenafil')
          ->setPosition(0);
        $questionTwoAnswerTwo = (new Answer())
          ->setText('Cialis or Tadalafil')
          ->setPosition(1);
        $questionTwoAnswerThree = (new Answer())
          ->setText('Both')
          ->setPosition(2);
        $questionTwoAnswerFour = (new Answer())
          ->setText('None of the above')
          ->setPosition(3)
          ->setProductRecommendations(new ArrayCollection([$silde50, $tadal10]));
        $questionTwoAnswers = [$questionTwoAnswerOne, $questionTwoAnswerTwo, $questionTwoAnswerThree, $questionTwoAnswerFour];

        $questionTwoAAnswerYes = (new Answer())
          ->setText('Yes')
          ->setPosition(0)
          ->setProductRecommendations(new ArrayCollection([$silde50]));
        $questionTwoAAnswerNo = (new Answer())
          ->setText('No')
          ->setPosition(1)
          ->setProductRecommendations(new ArrayCollection([$tadal20]));
        $questionTwoAAnswers = [$questionTwoAAnswerYes, $questionTwoAAnswerNo];

        $questionTwoBAnswerYes = (new Answer())
          ->setText('Yes')
          ->setPosition(0)
          ->setProductRecommendations(new ArrayCollection([$tadal10]));
        $questionTwoBAnswerNo = (new Answer())
          ->setText('No')
          ->setPosition(1)
          ->setProductRecommendations(new ArrayCollection([$silde100]));
        $questionTwoBAnswers = [$questionTwoBAnswerYes, $questionTwoBAnswerNo];

        $questionTwoCAnswerOne = (new Answer())
          ->setText('Viagra or Sildenafil')
          ->setPosition(0)
          ->setProductRecommendations(new ArrayCollection([$silde100]));
        $questionTwoCAnswerTwo = (new Answer())
          ->setText('Cialis or Tadalafil')
          ->setPosition(1)
          ->setProductRecommendations(new ArrayCollection([$tadal20]));
        $questionTwoCAnswerThree = (new Answer())
          ->setText('None of the above')
          ->setPosition(2)
          ->setProductRecommendations(new ArrayCollection([$silde100, $tadal20]));
        $questionTwoCAnswers = [$questionTwoCAnswerOne, $questionTwoCAnswerTwo, $questionTwoCAnswerThree];

        $questionThreeAnswerYes = (new Answer())
          ->setText('Yes')
          ->setPosition(0);
        $questionThreeAnswerNo = (new Answer())
          ->setText('No')
          ->setPosition(1)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionThreeAnswers = [$questionThreeAnswerYes, $questionThreeAnswerNo];

        $questionFourAnswerOne = (new Answer())
          ->setText('Significant liver problems (such as cirrhosis of the liver) or kidney problems')
          ->setPosition(0)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionFourAnswerTwo = (new Answer())
          ->setText('Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment')
          ->setPosition(1)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionFourAnswerThree = (new Answer())
          ->setText('Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)')
          ->setPosition(2)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionFourAnswerFour = (new Answer())
          ->setText("Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin)")
          ->setPosition(3)
          ->setProductRestrictions(new ArrayCollection($allProducts));
        $questionFourAnswerFive = (new Answer())
          ->setText('I don\'t have any of these conditions')
          ->setPosition(4);
        $questionFourAnswers = [$questionFourAnswerOne, $questionFourAnswerTwo, $questionFourAnswerThree, $questionFourAnswerFour, $questionFourAnswerFive];

        $answers = array_merge($questionOneAnswers, $questionTwoAnswers, $questionTwoAAnswers, $questionTwoBAnswers, $questionTwoCAnswers, $questionThreeAnswers, $questionFourAnswers);
        foreach ($answers as $answer) {
            $manager->persist($answer);
        }
        $manager->flush();

        /** QUESTIONS */
        $questionOne = (new Question())
          ->setText('Do you have difficulty getting or maintaining an erection?')
          ->setPosition(0)
          ->setAnswers(new ArrayCollection($questionOneAnswers));
        $questionTwo = (new Question())
          ->setText('Have you tried any of the following treatments before?')
          ->setPosition(1)
          ->setAnswers(new ArrayCollection($questionTwoAnswers));
        $questionTwoA = (new Question())
          ->setText('Was the Viagra or Sildenafil product you tried before effective?')
          ->setPosition(2)
          ->setAnswers(new ArrayCollection($questionTwoAAnswers))
          ->setAnswersRequiredToDisplay(new ArrayCollection([$questionTwoAnswerOne]));
        $questionTwoB = (new Question())
          ->setText('Was the Cialis or Tadalafil product you tried before effective?')
          ->setPosition(3)
          ->setAnswers(new ArrayCollection($questionTwoBAnswers))
          ->setAnswersRequiredToDisplay(new ArrayCollection([$questionTwoAnswerTwo]));
        $questionTwoC = (new Question())
          ->setText('Which is your preferred treatment?')
          ->setPosition(4)
          ->setAnswers(new ArrayCollection($questionTwoCAnswers))
          ->setAnswersRequiredToDisplay(new ArrayCollection([$questionTwoAnswerThree]));
        $questionThree = (new Question())
          ->setText('Do you have, or have you ever had, any heart or neurological conditions?')
          ->setPosition(5)
          ->setAnswers(new ArrayCollection($questionThreeAnswers));
        $questionFour = (new Question())
          ->setText('Do any of the listed medical conditions apply to you?')
          ->setPosition(6)
          ->setAnswers(new ArrayCollection($questionFourAnswers));

        $questions = [$questionOne, $questionTwo, $questionTwoA, $questionTwoB, $questionTwoC, $questionThree, $questionFour];

        foreach ($questions as $question) {
            $manager->persist($question);
        }
        $manager->flush();

        $this->addReference(self::QUESTION_ONE, $questionOne);
        $this->addReference(self::QUESTION_TWO, $questionTwo);
        $this->addReference(self::QUESTION_TWO_A, $questionTwoA);
        $this->addReference(self::QUESTION_TWO_B, $questionTwoB);
        $this->addReference(self::QUESTION_TWO_C, $questionTwoC);
        $this->addReference(self::QUESTION_THREE, $questionThree);
        $this->addReference(self::QUESTION_FOUR, $questionFour);
    }

    private function getFromObjectFixture(string $reference): array
    {
        return $this->getReference($reference)->getData();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }
}
