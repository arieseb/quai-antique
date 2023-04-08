<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route(path: '/mentions-legales', name: 'app_legal')]
    public function legal (): Response
    {
        return $this->render('legal/legal.html.twig');
    }
}