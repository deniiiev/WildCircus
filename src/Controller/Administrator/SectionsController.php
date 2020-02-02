<?php

namespace App\Controller\Administrator;

use App\Entity\Sections;
use App\Form\SectionsType;
use App\Repository\SectionsRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administrator/sections", name="administrator_sections_")
 */
class SectionsController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param SectionsRepository $sectionsRepository
     * @return Response
     */
    public function index(SectionsRepository $sectionsRepository): Response
    {
        return $this->render('administrator/sections/index.html.twig', [
            'sections' => $sectionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $section = new Sections();
        $form = $this->createForm(SectionsType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image, 'images');
                $section->setImage($imageName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($section);
            $entityManager->flush();

            return $this->redirectToRoute('administrator_sections_index');
        }

        return $this->render('administrator/sections/new.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Sections $section
     * @return Response
     */
    public function show(Sections $section): Response
    {
        return $this->render('administrator/sections/show.html.twig', [
            'section' => $section,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Sections $section
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, Sections $section, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SectionsType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $fileUploader->remove('images', $section->getImage());
                $imageName = $fileUploader->upload($image, 'images');
                $section->setImage($imageName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrator_sections_index');
        }

        return $this->render('administrator/sections/edit.html.twig', [
            'section' => $section,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Sections $section
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function delete(Request $request, Sections $section, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->request->get('_token'))) {
            $fileUploader->remove('images', $section->getImage());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($section);
            $entityManager->flush();
        }

        return $this->redirectToRoute('administrator_sections_index');
    }
}
