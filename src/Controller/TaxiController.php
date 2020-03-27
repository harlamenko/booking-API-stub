<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Stubs\Taxi;
use App\Models\MTaxi;
use App\Entity\Validator;

class TaxiController
{
    public function get(Request $request)
    {
        $aid = $request->query->get('aid');
        $object;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($aid, Taxi::$stubObjects)) {
            $object = Taxi::$stubObjects[$aid];
            $code = Response::HTTP_OK;
        } else {
            $object = '"Not Found"';
            $code = Response::HTTP_NOT_FOUND;
        }
        
        $response->setContent($object);
        $response->setStatusCode($code);
        
        return $response;
    }

    public function add(Request $request, ValidatorInterface $validator) {
        $content = $request->getContent();
        $object = new MTaxi(json_decode($content));
        $errors = $validator->validate($object);
        $result;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (count($errors)) {
            $humanized_errors = Validator::humanize($errors);
            $code = Response::HTTP_BAD_REQUEST;
            $result = json_encode($humanized_errors);
        } else {
            $code = Response::HTTP_OK;
            $result = '{"id": ' . Taxi::aid . '}';
        }

        $response->setContent($result);
        $response->setStatusCode($code);

        return $response;
    }
    
    public function update(Request $request, ValidatorInterface $validator) {
        $aid = $request->query->get('aid');
        $content = $request->getContent();
        $result;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($aid, Taxi::$stubObjects)) {
            $json_decodedContent = json_decode($content);
            $object = new MTaxi($json_decodedContent);
            $errors = $validator->validate($object);
        
            if (count($errors)) {
                $humanized_errors = Validator::humanize($errors);
                $code = Response::HTTP_BAD_REQUEST;
                $result = json_encode($humanized_errors);
            } else {
                $code = Response::HTTP_OK;
                $result = '"Ok"';
            }
        } else {
            $code = Response::HTTP_NOT_FOUND;
            $result = '"Not Found"';
        }

        $response->setContent($result);
        $response->setStatusCode($code);

        return $response;
    }
}