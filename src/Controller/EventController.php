<?php


namespace App\Controller;


use App\Entity\Event;
use App\Type\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    /**
     * @param int $eventId
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function deleteEvent(int $eventId, EntityManagerInterface $em)
    {
        $eventRepo = $em->getRepository(Event::class);
        $event = $eventRepo->findOneBy(['id' => $eventId]);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @param int $eventId
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editEvent(int $eventId, EntityManagerInterface $em, Request $request)
    {
        $eventRepo = $em->getRepository(Event::class);

        $event = $eventRepo->findOneBy(['id' => $eventId]);

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {

            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('event/eventEdit.html.twig', [
            'form' => $eventForm->createView(),
        ]);
    }
}