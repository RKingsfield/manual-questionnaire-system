<?php

use App\Entity\Answer;
use App\Entity\Product;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Service\QuestionnaireService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuestionnaireServiceTest extends KernelTestCase
{
  private QuestionnaireService $questionnaireService;

  public function testRecommendationIsGiven(): void
  {
    $mockedProduct = $this->createMockProduct('123');
    $mockedAnswer = $this->createMockAnswer([$mockedProduct]);
    $mockedQuestion = $this->createMockQuestion([$mockedAnswer]);

    $mockedQuestionnaireService = $this->getMockBuilder(QuestionnaireService::class)
      ->disableOriginalConstructor()
      ->setMethods(['getQuestion', 'getAnswer'])
      ->getMock();
    $mockedQuestionnaireService->method('getQuestion')->willReturn($mockedQuestion);
    $mockedQuestionnaireService->method('getAnswer')->willReturn($mockedAnswer);

    $recommendation = $mockedQuestionnaireService->getProductRecommendations(
      new Questionnaire(),
      [
        [
          'questionId' => '123',
          'answerId' => '124'
        ]
      ]
    );

    $this->assertSame($recommendation, [$mockedProduct]);
  }

  public function testRecommendationIsHiddenWhenRestrictedByDifferentQuestion(): void
  {
    $productOne = $this->createMockProduct('1234');
    $productTwo = $this->createMockProduct('4567');

    $mockedAnswerOne = $this->createMockAnswer([$productOne, $productTwo]);
    $mockedAnswerTwo = $this->createMockAnswer(restrictedProducts: [$productTwo]);

    $mockQuestionOne = $this->createMockQuestion([$mockedAnswerOne]);
    $mockQuestionTwo = $this->createMockQuestion([$mockedAnswerTwo]);

    $mockedQuestionnaireService = $this->getMockBuilder(QuestionnaireService::class)
      ->disableOriginalConstructor()
      ->setMethods(['getQuestion', 'getAnswer'])
      ->getMock();
    $mockedQuestionnaireService->method('getQuestion')->will($this->onConsecutiveCalls($mockQuestionOne, $mockQuestionTwo));
    $mockedQuestionnaireService->method('getAnswer')->will($this->onConsecutiveCalls($mockedAnswerOne, $mockedAnswerTwo));

    $recommendation = $mockedQuestionnaireService->getProductRecommendations(
      new Questionnaire(),
      [
        [
          'questionId' => '123',
          'answerId' => '456'
        ],
        [
          'questionId' => '321',
          'answerId' => '654'
        ],
      ]
    );

    $this->assertSame($recommendation, [$productOne]);
  }

  protected function createMockProduct(string $id)
  {
    $product = $this->createMock(Product::class);
    $product->method('__toString')
      ->willReturn($id);
    return $product;
  }

  protected function createMockAnswer(array $recommendedProducts = [], array $restrictedProducts = [])
  {
    $answer = $this->createMock(Answer::class);
    $answer->method('getProductRecommendations')
      ->willReturn(new ArrayCollection($recommendedProducts));
    $answer->method('getProductRestrictions')
      ->willReturn(new ArrayCollection($restrictedProducts));
    return $answer;
  }

  protected function createMockQuestion(array $answers = [])
  {
    $question = $this->createMock(Question::class);
    $question->method('getAnswers')
      ->willReturn(new ArrayCollection($answers));
    return $question;
  }
}
