<?php


namespace App\Controller;


use App\Entity\Event;
use App\Type\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function createEvent(Request $request, EntityManagerInterface $em)
    {
        $event = new Event();

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('event/eventCreate.html.twig', [
            'form' => $eventForm->createView(),
        ]);
    }
}