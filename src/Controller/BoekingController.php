<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;

/**
 * @Route("/boeking")
 */
class BoekingController extends AbstractController
{
    /**
     * @Route("/", name="boeking_index", methods={"GET"})
     */
    /*public function index (ReservationRepository $reservationRepository, RoomRepository $roomRepository): Response
    {
        return $this->render('boeking/index.html.twig', [
            'reservations' => $reservationRepository->findRoomsReserved(['checkin' => '2019-05-17', 'checkout' => '2019-05-24']),
        ]);
    }/*


    /*public function index (ReservationRepository $reservationRepository, RoomRepository $roomRepository): Response
    {
        // get the cart from  the session
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $roomboeking = $session->get('roomboeking', array());
        
        //if (empty($roomboeking)) {
        $datum = new \DateTime("now");
        $roomboeking = ['checkin' => $datum, 'checkout' => $datum];
        $form = $this->createFormBuilder($roomboeking)
            ->add('checkin', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
            //    'format' => 'dd-MM-yyyy',
                ])
            ->add('checkout', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                //   'format' => 'dd-MM-yyyy',
            ])
            ->add('save', SubmitType::class, array('label' => 'Check rooms'))
            ->getForm();
        //}
        return $this->render('boeking/index.html.twig', [
            'controller_name' => 'BoekingController',
            'form' => $form->createView(),
        ]);
    }*/



    /**
     * @Route("/", name="boeking_index", methods={"GET"})
     */
    public function index (ReservationRepository $reservationRepository, RoomRepository $roomRepository): Response
    {
        return $this->render('boeking/index.html.twig', [
            /*'reservations' => $reservationRepository->findRoomsReserved(['checkin' => '2019-05-17', 'checkout' => '2019-05-24']),*/
            'rooms' => $roomRepository->findFreeRooms(['checkin' => '2019-05-17', 'checkout' => '2019-05-24']),
        ]);
    }
}
