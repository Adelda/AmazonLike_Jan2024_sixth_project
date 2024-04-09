<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxExampleController extends AbstractController
{
    #[Route('/ajaxexample', name: 'app_ajax_example')]
    public function index(): Response
    {
        return $this->render('ajax_example/index.html.twig', [
            'controller_name' => 'AjaxExampleController',
        ]);
    }
}
