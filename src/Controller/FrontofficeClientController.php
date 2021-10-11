<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use App\Entity\Region;
use App\Entity\Comment;

/**
 * @Route("/region")
*/

class FrontofficeClientController extends AbstractController

{    
    /**
     * @Route("/", name="frontoffice_client")
     */
    public function index(): Response
    {  
        $em = $this->getDoctrine()->getManager();
        $regionRepo = $em->getRepository(Region::class);
        $region = $regionRepo->findAll();
        
        return $this->render('frontoffice_client/index.html.twig', ['region' => $region,]);
    }
    
    /**
     * @Route("/frontoffice/client/{id}", name="frontoffice_client_rooms", requirements={"id":"\d+"})
     */
    
    public function rooms(Region $region): Response{
        $em = $this->getDoctrine()->getManager();
        $roomRepo = $em->getRepository(Room::class);
        $room = $roomRepo->findAll();
        
        return $this->render('frontoffice_client/rooms.html.twig', [
            'rooms' => $region->getRooms(),
            'region' => $region,
        ]);
    }
    
    /**
     * @Route("/frontoffice/client/rooms/{id}", name="frontoffice_client_room", requirements={"id":"\d+"})
     */
    
    public function room(Room $room): Response{
        $em = $this->getDoctrine()->getManager();
        $commentRepo = $em->getRepository(Comment::class);
        $comment = $commentRepo->findAll();

        return $this->render('frontoffice_client/room.html.twig', [
            'room' => $room,
            'comment' => $comment,
        ]);
    }
}
