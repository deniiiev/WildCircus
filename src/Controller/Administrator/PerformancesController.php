<?php

namespace App\Controller\Administrator;

use App\Entity\Performances;
use App\Form\PerformancesType;
use App\Repository\PerformancesRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administrator/performances", name="administrator_performances_")
 */
class PerformancesController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param PerformancesRepository $performancesRepository
     * @return Response
     */
    public function index(PerformancesRepository $performancesRepository): Response
    {
        return $this->render('administrator/performances/index.html.twig', [
            'performances' => $performancesRepository->findAll()
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
        $performance = new Performances();
        $form = $this->createForm(PerformancesType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image, 'images');
                $performance->setImage($imageName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($performance);
            $entityManager->flush();

            return $this->redirectToRoute('administrator_performances_index');
        }

        return $this->render('administrator/performances/new.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Performances $performance
     * @return Response
     */
    public function show(Performances $performance): Response
    {
        return $this->render('administrator/performances/show.html.twig', [
            'performance' => $performance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Performances $performance
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Request $request, Performances $performance, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PerformancesType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $fileUploader->remove('images', $performance->getImage());
                $imageName = $fileUploader->upload($image, 'images');
                $performance->setImage($imageName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrator_performances_index');
        }

        return $this->render('administrator/performances/edit.html.twig', [
            'performance' => $performance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Performances $performance
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function delete(Request $request, Performances $performance, FileUploader $fileUploader): Response
    {
        if ($this->isCsrfTokenValid('delete'.$performance->getId(), $request->request->get('_token'))) {
            $fileUploader->remove('images', $performance->getImage());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($performance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('administrator_performances_index');
    }
}
