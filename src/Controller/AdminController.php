<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin', methods: ['GET'])]
    public function adminUser(UserRepository $userRepository,VoyageRepository $voyageRepository,ReservationRepository $reservationRepository, PaginatorInterface  $paginator, Request $request): Response
    {
        $nbvoyage = $voyageRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        
            $nbreservation = $reservationRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $reservations = $paginator->paginate($reservationRepository->findAll(),$request->query->getInt('page', 1),5);
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'voyages' => $voyageRepository->findAll(),
            'reservations' => $reservations,
            'nbvoyage' => $nbvoyage,
            'nbreservation'=> $nbreservation
        ]);
    }
    

}