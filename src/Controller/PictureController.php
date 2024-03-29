<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/picture')]
class PictureController extends AbstractController
{
    /**
     * @param PictureRepository $pictureRepository
     * @return Response
     */
    #[Route('/', name: 'app_picture_index', methods: ['GET'])]
    public function index(PictureRepository $pictureRepository): Response
    {
        return $this->render('picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @param PictureRepository $pictureRepository
     * @return Response
     */
    #[Route('/new', name: 'app_picture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PictureRepository $pictureRepository): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('images')->getData();
            $file = uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('images_directory'), $file);
            $picture->setPath($file);
            $pictureRepository->save($picture, true);

            return $this->redirectToRoute('app_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/new.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    /**
     * @param Picture $picture
     * @return Response
     */
    #[Route('/{id}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    /**
     * @param Request $request
     * @param Picture $picture
     * @param PictureRepository $pictureRepository
     * @return Response
     */
    #[Route('/{id}/edit', name: 'app_picture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('images')->getData();
            $file = uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('images_directory'), $file);
            $picture->setPath($file);
            $pictureRepository->save($picture, true);

            return $this->redirectToRoute('app_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param Picture $picture
     * @param PictureRepository $pictureRepository
     * @return Response
     */
    #[Route('/{id}', name: 'app_picture_delete', methods: ['POST'])]
    public function delete(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $filePath = $picture->getPath();
            unlink($this->getParameter('images_directory').'/'.$filePath);
            $pictureRepository->remove($picture, true);
        }

        return $this->redirectToRoute('app_picture_index', [], Response::HTTP_SEE_OTHER);
    }
}
