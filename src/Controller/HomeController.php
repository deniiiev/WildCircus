<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Form\TicketsType;
use App\Repository\SectionsRepository;
use App\Repository\PerformancesRepository;
use App\Repository\PricesRepository;
use App\Repository\TicketsRepository;
use App\Repository\UserRepository;
use App\Services\CounterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param PerformancesRepository $performances
     * @param PricesRepository $prices
     * @param SectionsRepository $sections
     * @param UserRepository $userRepository
     * @param TicketsRepository $ticketsRepository
     * @param CounterService $counterService
     * @return Response
     */
    public function index(
        Request $request,
        PerformancesRepository $performances,
        PricesRepository $prices,
        SectionsRepository $sections,
        UserRepository $userRepository,
        TicketsRepository $ticketsRepository,
        CounterService $counterService)
    {
        $form = $this->createForm(TicketsType::class, null,[
            'prices' => $prices->findAll()
        ]);
        $form->handleRequest($request);

        $cart = null;

        if ($this->getUser()) {
            $cart = $counterService->status(['user' => $this->getUser()->getId(), 'status' => 0]);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userRepository->findOneBy(['id' => $this->getUser()->getId()]);

            foreach ($prices->findAll() as $value){

                if ($form->get(str_replace(' ','',strtolower($value->getService())))->getData() >= 1) {

                    $ticketExist = $ticketsRepository->findOneBy([
                        'user' => $this->getUser()->getId(),
                        'price' => $value->getId(),
                        'days' => $form->get('days')->getData(),
                        'status' => 0
                    ]);

                    if ($ticketExist == null) {
                        $ticket = new Tickets();
                        $ticket->setUser($user);
                        $ticket->setPrice($value);
                        $ticket->setCount($form->get(str_replace(' ','',strtolower($value->getService())))->getData());
                        $ticket->setStatus(false);
                        $ticket->setDays($form->get('days')->getData());

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($ticket);
                        $entityManager->flush();
                    } else {
                        $ticketExist->setCount($form->get(str_replace(' ','',strtolower($value->getService())))->getData() + $ticketExist->getCount());
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->flush();
                    }
                }

            }
            $this->addFlash('success','Your tickets is added to cart successfully.');
            return $this->redirectToRoute('app_cart');
        }

        return $this->render('home/index.html.twig', [
            'performances' => $performances->findAll(),
            'prices' => $prices->findAll(),
            'sections' => $sections->findAll(),
            'form' => $form->createView(),
            'cart' => $cart
        ]);
    }

    /**
     * @Route("/pay", name="pay")
     * @param TicketsRepository $ticketsRepository
     * @return Response
     */
    public function pay(TicketsRepository $ticketsRepository): Response
    {
        $tickets = $ticketsRepository->findBy(['user' => $this->getUser()]);
        foreach ($tickets as $value) {
            $value->setStatus(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        $this->addFlash('success','Your payment has been successfully completed.');
        return $this->redirectToRoute('app_cart');
    }
}
