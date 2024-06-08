<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Product;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionnaireService
{
    private $answerRepository;
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    /** @return Product[] */
    public function getProductRecommendations(Questionnaire $questionnaire, array $payload): array
    {
        $recommendations = [];
        $restrictions = [];
        foreach ($payload as $pairedResponse) {
            $questionId = $pairedResponse['questionId'];
            $answerId = $pairedResponse['answerId'];

            $question = $this->getQuestion($questionId);
            $answer = $this->getAnswer($answerId);
            if (!$question->getAnswers()->contains($answer)) {
                throw new NotFoundHttpException("Answer '$answerId' could not be found on Question '$questionId'");
            }

            $recommendations = array_merge($recommendations, $answer->getProductRecommendations()->toArray());
            $restrictions = array_merge($restrictions, $answer->getProductRestrictions()->toArray());
        }

        // Strips out any recommendations that have been restricted by a different answer.
        return array_diff($recommendations, $restrictions);
    }

    protected function getQuestion(string $questionId): ?Question
    {
        $question = $this->questionRepository->findOneById($questionId);
        if (empty($question)) {
            throw new NotFoundHttpException("Question '$questionId' could not be found");
        }

        return $question;
    }

    protected function getAnswer(string $answerId): ?Answer
    {
        $answer = $this->answerRepository->findOneById($answerId);
        if (empty($answer)) {
            throw new NotFoundHttpException("Answer '$answer' could not be found");
        }

        return $answer;
    }
}
