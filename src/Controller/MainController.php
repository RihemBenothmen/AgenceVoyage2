<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

 
    #[Route('/', name: 'app_main')]
    public function index(Request $request, EntityManagerInterface $entityManager,VoyageRepository $voyageRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prixVoyage = $reservation->getVoyage()->getPrix();
            $montant = ($prixVoyage * $reservation->getAdulte()) + (($prixVoyage / 2) * $reservation->getEnfant());
            
            // Enregistrez le montant dans l'objet de réservation
            $reservation->setMontant($montant);
            $entityManager->persist($reservation);
            $entityManager->flush();


            return $this->redirectToRoute('recapitulatif', ['id' => $reservation->getId()],Response::HTTP_SEE_OTHER);
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'reservation' => $reservation,
            'form' => $form,
            'voyages' => $voyageRepository->findAll(),
        ]);
    }

    #[Route('/reservation/{id}', name: 'recapitulatif', methods: ['GET'])]
    public function recapitulatif(Reservation $reservation): Response
    {
        return $this->render('reservation/recapitulatif.html.twig', [
            'reservation' => $reservation,
        ]);
    }
    

    #[Route('/about', name: 'app_about')]
    public function about_route(): Response
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/service', name: 'app_service')]
    public function service_route(): Response
    {
        return $this->render('main/service.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/booking/{id}', name: 'app_booking')]
    public function booking_route(Request $request, EntityManagerInterface $entityManager, Voyage $voyage): Response
    {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $prixVoyage =$voyage->getPrix();
            $montant = ($prixVoyage * $reservation->getAdulte()) + (($prixVoyage / 2) * $reservation->getEnfant());
            
            $reservation->setVoyage($voyage);
            $reservation->setMontant($montant);
            $entityManager->persist($reservation);
            $entityManager->flush();


            return $this->redirectToRoute('recapitulatif', ['id' => $reservation->getId()],Response::HTTP_SEE_OTHER);
        }
        return $this->render('main/booking.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form,
        ]);
    }


    #[Route('/contact', name: 'app_contact')]
    public function contact_route(): Response
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/destination', name: 'app_destination')]
    public function destination_route(): Response
    {
        return $this->render('main/destination.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/package', name: 'app_package')]
    public function package_route(): Response
    {
        return $this->render('main/package.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/voyage/{id}', name: 'voyage_show', methods: ['GET'])]
    public function show(Voyage $voyage): Response
    {
        return $this->render('main/voyage.html.twig', [
            'voyage' => $voyage,
        ]);
    }

}
