<?php

namespace App\Controller;

use App\Repository\TicketsRepository;
use App\Services\CounterService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/cart", name="app_cart")
     * @param TicketsRepository $ticketsRepository
     * @param CounterService $counterService
     * @return Response
     */
    public function profile(TicketsRepository $ticketsRepository, CounterService $counterService): Response {

        if (!$this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $totalCart = $counterService->total(['user' => $this->getUser()->getId(), 'status' => 0]);
        $totalPurchased = $counterService->total(['user' => $this->getUser()->getId(), 'status' => 1]);
        $cartStatus = $counterService->status(['user' => $this->getUser()->getId(), 'status' => 0]);
        $purchasedStatus = $counterService->status(['user' => $this->getUser()->getId(), 'status' => 1]);

        return $this->render('security/cart.html.twig', [
            'tickets' => $ticketsRepository->findBy(['user' => $this->getUser()->getId()]),
            'totalCart' => $totalCart,
            'totalPurchased' => $totalPurchased,
            'cartStatus' => $cartStatus,
            'purchasedStatus' => $purchasedStatus
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
