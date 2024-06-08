<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Product;
use App\Entity\Question;
use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

class AppFixtures extends Fixture
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function load(ObjectManager $manager): void
    {
        /** PRODUCTS */
        $sild100 = (new Product())->setName('Sildenafil 100mg');
        $sild50 = (new Product())->setName('Sildenafil 50mg');
        $tada10 = (new Product())->setName('Tadalafil 10mg');
        $tada20 = (new Product())->setName('Tadalafil 20mg');
        $products = [$sild100, $sild50, $tada10, $tada20];

        foreach ($products as $product) {
            $manager->persist($product);
        }
        $manager->flush();

        /** ANSWERS */
        $questionOneAnswerYes = (new Answer())
            ->setText('Yes')
            ->setPosition(0);
        $questionOneAnswerNo = (new Answer())
            ->setText('No')
            ->setPosition(1)
            ->setProductRestrictions(new ArrayCollection($products));
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
            ->setProductRecommendations(new ArrayCollection([$sild50, $tada10]));
        $questionTwoAnswers = [$questionTwoAnswerOne, $questionTwoAnswerTwo, $questionTwoAnswerThree, $questionTwoAnswerFour];

        $questionTwoAAnswerYes = (new Answer())
            ->setText('Yes')
            ->setPosition(0)
            ->setProductRecommendations(new ArrayCollection([$sild50]));
        $questionTwoAAnswerNo = (new Answer())
            ->setText('No')
            ->setPosition(1)
            ->setProductRecommendations(new ArrayCollection([$tada20]));
        $questionTwoAAnswers = [$questionTwoAAnswerYes, $questionTwoAAnswerNo];

        $questionTwoBAnswerYes = (new Answer())
            ->setText('Yes')
            ->setPosition(0)
            ->setProductRecommendations(new ArrayCollection([$tada10]));
        $questionTwoBAnswerNo = (new Answer())
            ->setText('No')
            ->setPosition(1)
            ->setProductRecommendations(new ArrayCollection([$sild100]));
        $questionTwoBAnswers = [$questionTwoBAnswerYes, $questionTwoBAnswerNo];

        $questionTwoCAnswerOne = (new Answer())
            ->setText('Viagra or Sildenafil')
            ->setPosition(0)
            ->setProductRecommendations(new ArrayCollection([$sild100]));
        $questionTwoCAnswerTwo = (new Answer())
            ->setText('Cialis or Tadalafil')
            ->setPosition(1)
            ->setProductRecommendations(new ArrayCollection([$tada20]));
        $questionTwoCAnswerThree = (new Answer())
            ->setText('None of the above')
            ->setPosition(2)
            ->setProductRecommendations(new ArrayCollection([$sild100, $tada20]));
        $questionTwoCAnswers = [$questionTwoCAnswerOne, $questionTwoCAnswerTwo, $questionTwoCAnswerThree];

        $questionThreeAnswerYes = (new Answer())
            ->setText('Yes')
            ->setPosition(0);
        $questionThreeAnswerNo = (new Answer())
            ->setText('No')
            ->setPosition(1)
            ->setProductRestrictions(new ArrayCollection($products));
        $questionThreeAnswers = [$questionThreeAnswerYes, $questionThreeAnswerNo];

        $questionFourAnswerOne = (new Answer())
            ->setText('Significant liver problems (such as cirrhosis of the liver) or kidney problems')
            ->setPosition(0)
            ->setProductRestrictions(new ArrayCollection($products));
        $questionFourAnswerTwo = (new Answer())
            ->setText('Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment')
            ->setPosition(1)
            ->setProductRestrictions(new ArrayCollection($products));
        $questionFourAnswerThree = (new Answer())
            ->setText('Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)')
            ->setPosition(2)
            ->setProductRestrictions(new ArrayCollection($products));
        $questionFourAnswerFour = (new Answer())
            ->setText("Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin)")
            ->setPosition(3)
            ->setProductRestrictions(new ArrayCollection($products));
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

        /** QUESTIONNAIRE */
        $questionnaire = (new Questionnaire())
            ->setDescription('A short questionnaire designed to determine which product is best for you')
            ->setSlug('erectile-health')
            ->setQuestions(new ArrayCollection($questions));

        $manager->persist($questionnaire);
        $manager->flush();
    }
}
