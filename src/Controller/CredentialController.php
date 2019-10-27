<?php


namespace App\Controller;


use App\Entity\User;
use App\Type\UserType;
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

    public function registration(Request $request)
    {
        /**
         * @var User $user
         */
        $user = new User();

        $regForm = $this->createForm(UserType::class, $user);
        $regForm->handleRequest($request);

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
}