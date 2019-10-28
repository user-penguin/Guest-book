<?php


namespace App\Twig;


use App\Repository\ReviewRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CounterExtension extends AbstractExtension
{
    private $reviewRepository;

    /**
     * CounterExtension constructor.
     * @param ReviewRepository $reviewRepository
     */
    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getReviewsCount', [$this, 'getReviewsCount']),
        ];
    }

    /**
     * @param int $eventId
     * @return int
     */
    public function getReviewsCount(int $eventId)
    {
        return $this->reviewRepository->getCountOfRecords($eventId);
    }
}