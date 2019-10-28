<?php


namespace App\Controller;


use App\Entity\Event;
use App\Entity\Review;
use App\Entity\User;
use App\Type\EventType;
use App\Type\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

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

    /**
     * @param int $eventId
     * @param int $page
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param Security $security
     * @return Response
     */
    public function viewEvent(int $eventId, int $page, EntityManagerInterface $em, Request $request, Security $security)
    {
        $paginationSize = 5;

        $reviewRepo = $em->getRepository(Review::class);
        $allReviews = $reviewRepo->getEventsForPagination($eventId, $paginationSize, $page);

        $countOfRecords = $reviewRepo->getCountOfRecords($eventId);

        $allPages = intval($countOfRecords / $paginationSize);
        if ($countOfRecords % $paginationSize > 0 && $countOfRecords > $paginationSize) {
            $allPages++;
        } else {
            $allPages = 1;
        }

        $eventRepo = $em->getRepository(Event::class);
        $event = $eventRepo->findOneBy(['id' => $eventId]);

        /**
         * @var User $user
         */
        $user = $security->getUser();

        $review = new Review();
        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);

        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) {

            $review->setEvent($event);
            $review->setUser($user);

            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('view_event', ['eventId' => $eventId]);
        }

        return $this->render('event/eventView.html.twig', [
            'event' => $event,
            'form' => $reviewForm->createView(),
            'allReviews' => $allReviews,
            'allPages' => $allPages
        ]);
    }
}