<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Stubs\Taxies;
use App\Entity\Taxi;
use App\Common\Validator;

/**
 * @Route("/api", name="taxi_api")
 */
class TaxiController
{
    /**
     * @Route("/taxi", name="taxi", methods={"GET"})
     */
    public function get(Request $request)
    {
        $aid = $request->query->get('aid');
        $object;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($aid, Taxies::$stubObjects)) {
            $object = Taxies::$stubObjects[$aid];
            $code = Response::HTTP_OK;
        } else {
            $object = '"Not Found"';
            $code = Response::HTTP_NOT_FOUND;
        }
        
        $response->setContent($object);
        $response->setStatusCode($code);
        
        return $response;
    }
    /**
     * @Route("/taxi", name="taxi_add", methods={"POST"})
     */
    public function add(Request $request, ValidatorInterface $validator) {
        $content = $request->getContent();
        $object = new Taxi(json_decode($content));
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
            $result = '{"id": ' . Taxies::aid . '}';
        }

        $response->setContent($result);
        $response->setStatusCode($code);

        return $response;
    }
    /**
     * @Route("/taxi", name="taxi_update", methods={"PUT"})
     */
    public function update(Request $request, ValidatorInterface $validator) {
        $aid = $request->query->get('aid');
        $content = $request->getContent();
        $result;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($aid, Taxies::$stubObjects)) {
            $json_decodedContent = json_decode($content);
            $object = new Taxi($json_decodedContent);
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
    /**
     * @Route("/taxi", name="taxi_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $aid = $request->query->get('aid');
        $content;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($aid, Taxies::$stubObjects)) {
            $content = '"Ok"';
            $code = Response::HTTP_OK;
        } else {
            $content = '"Not Found"';
            $code = Response::HTTP_NOT_FOUND;
        }
        
        $response->setContent($content);
        $response->setStatusCode($code);

        return $response;
    }
}