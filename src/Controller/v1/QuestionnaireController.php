<?php

namespace App\Controller\v1;

use App\Entity\Questionnaire;
use App\Repository\QuestionnaireRepository;
use App\Service\QuestionnaireService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionnaireController extends AbstractController
{
    private QuestionnaireRepository $questionnaireRepository;
    private SerializerInterface $serializer;

    public function __construct(QuestionnaireRepository $questionnaireRepository, SerializerInterface $serializer)
    {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->serializer = $serializer;
    }

    #[Route('/v1/questionnaires', name: 'get_questionnaires', methods: ['GET'], format: 'json')]
    public function getQuestionnaires(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                ['data' => $this->questionnaireRepository->findAll()],
                'json',
                [AbstractNormalizer::IGNORED_ATTRIBUTES => ['questions']]
            ),
            json: true
        );
    }

    #[Route('/v1/questionnaire/{slug}', name: 'get_questionnaire', methods: ['GET'], format: 'json')]
    public function getQuestionnaire(string $slug): Response
    {
        return new JsonResponse(
            $this->serializer->serialize(
                ['data' => $this->getQuestionnaireBySlug($slug)],
                'json',
                [AbstractNormalizer::IGNORED_ATTRIBUTES => ['productRecommendations', 'productRestrictions']]
            ),
            json: true
        );
    }

    #[Route('/v1/questionnaire/{slug}/submission', name: 'submit_questionnaire_reponse', methods: ['POST'], format: 'json')]
    public function postQuestionnaireSubmission(string $slug, Request $request, QuestionnaireService $questionnaireService): JsonResponse
    {
        $questionnaire = $this->getQuestionnaireBySlug($slug);

        return new JsonResponse(
            $this->serializer->serialize(['data' => $questionnaireService->getProductRecommendations($questionnaire, $request->getPayload()->all())], 'json'),
            json: true
        );
    }

    private function getQuestionnaireBySlug(string $slug): Questionnaire
    {
        $questionnaire = $this->questionnaireRepository->findOneBySlug($slug);
        if (is_null($questionnaire)) {
            throw new NotFoundHttpException("Questionnaire '$slug' could not be found");
        }

        return $questionnaire;
    }
}
