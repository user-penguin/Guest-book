<?php


namespace App\Controller;


use App\Entity\User;
use App\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CredentialController extends AbstractController
{

    /**
     * @param Security $security
     * @return Response
     */
    public function index(Security $security)
    {
        dump($security->getUser());
        return $this->render('index.html.twig');
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function registration(Request $request, EntityManagerInterface $em)
    {
        /**
         * @var User $user
         */
        $user = new User();

        $regForm = $this->createForm(UserType::class, $user);
        $regForm->handleRequest($request);

        if ($regForm->isSubmitted() && $regForm->isValid()) {

            $user->setRoles(["user"]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registration.html.twig', [
            'form' => $regForm->createView(),
        ]);
    }


    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
                ]);
    }


    public function logout()
    {
    }
}