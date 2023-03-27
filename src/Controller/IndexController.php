<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'app_index')]
    public function index(PictureRepository $pictureRepository): Response
    {
        $pictures = $pictureRepository->findAll();
        return $this->render('index.html.twig', [
            'pictures' => $pictures,
        ]);
    }
}