<?php


namespace App\Controller;


use App\Entity\Review;
use App\Type\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends AbstractController
{
    public function createReview(int $eventId, Request $request)
    {
        $review = new Review();

        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);

        return $this->render('review/reviewCreate.html.twig', [
            'form' => $reviewForm,
        ]);
    }
}