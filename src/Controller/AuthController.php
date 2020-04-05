<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Common\Responsible;
use App\Common\Validator;
use App\Repository\UserRepository;

class AuthController extends AbstractController 
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(
        Request $request,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $encoder,
        JWTTokenManagerInterface $JWTManager,
        UserRepository $userRepository
    ) {
        $em = $this->getDoctrine()->getManager();
        $request = Responsible::transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setUsername($username);
        
        if (count($userRepository->findBy(['username' => $user->getUsername()]))) {
            return Responsible::formNotAcceptable('Пользователь с таким логином уже зарегистрирован!');
        }
        
        $errors = $validator->validate($user);

        if (count($errors)) {
            return Responsible::formBadRequest($errors);
        }
        
        $em->persist($user);
        $em->flush();
        return Responsible::response([
            'token' => $JWTManager->create($user)
        ]);
    }

    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }
}