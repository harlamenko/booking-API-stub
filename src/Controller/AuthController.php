<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Common\Validator;

/**
 * @Route("/api", name="auth_api")
 */
class AuthController {
    /**
     * @Route("/registration", name="register", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator) {
        $content = $request->getContent();
        $decoded_content = json_decode($content);
        $auth = new User($decoded_content->username, $decoded_content->password);
        $errors = $validator->validate($auth);
        $result; $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (count($errors)) {
            $humanized_errors = Validator::humanize($errors);
            $code = Response::HTTP_BAD_REQUEST;
            $result = json_encode($humanized_errors);
        } else {
            $code = Response::HTTP_OK;
            $result = json_encode([
                "accessToken" => "a9a09ba678c6dbf0fe55aa1cd7d0260fc9e6590d32a7747ff3d724f529609ae99d542ddea2de1a5d7024cc04acd324c7b19aa5ac73daf8953a1502ae26d0ed96"
            ]);
        }

        $response->setContent($result);
        $response->setStatusCode($code);

        return $response;
    }
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request, ValidatorInterface $validator) {
        return $this->register($request, $validator);
    }
    
}