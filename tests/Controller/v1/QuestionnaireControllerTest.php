<?php

namespace App\Test\Controller\v1;

use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionnaireControllerTest extends WebTestCase
{
  public function testQuestionnaireControllerReturnsValidQuestionnaire(): void
  {
    $client = static::createClient();
    $client->request('GET', '/v1/questionnaires');

    // Validate a successful response and doctrine is functioning
    $this->assertResponseIsSuccessful();
    $responseData = json_decode($client->getResponse()->getContent(), true);
    $this->assertEquals('erectile-health', $responseData['data'][0]['slug']);
  }
}