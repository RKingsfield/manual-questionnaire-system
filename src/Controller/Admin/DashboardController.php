<?php

namespace App\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Product;
use App\Entity\Question;
use App\Entity\Questionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(QuestionnaireCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Questionnaires'),
            MenuItem::linkToCrud('Questionnaires', 'fa fa-newspaper', Questionnaire::class),
            MenuItem::linkToCrud('Questions', 'fa fa-question', Question::class),
            MenuItem::linkToCrud('Answers', 'fa fa-comment-dots', Answer::class),

            MenuItem::section('Products'),
            MenuItem::linkToCrud('Products', 'fa fa-pills', Product::class),
        ];
    }
}
