<?php


namespace App\DoctrineListener;


use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderListener implements EventSubscriber
{
    private $passwordEncoder;

    /**
     * PasswordEncoderSubscriber constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::prePersist,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getEntityManager();

        $changes = $entityManager->getUnitOfWork()->getEntityChangeSet($entity);

        if ($entity instanceof User && (array_key_exists('password', $changes) || sizeof($changes) == 0 )) {

            $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPassword()));
        }
    }
}