<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Stubs\Objects;
use App\Models\MObject;
use App\Entity\Validator;

class ObjectController
{
    public function get(Request $request)
    {
        $oid = $request->query->get('oid');
        $object;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($oid, Objects::$stubObjects)) {
            $object = Objects::$stubObjects[$oid];
            $response->setStatusCode(Response::HTTP_OK);
        } else {
            $object = '"Not Found"';
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        
        $response->setContent($object);
        
        return $response;
    }

    public function add(Request $request, ValidatorInterface $validator) {
        $content = $request->getContent();
        $object = new MObject(json_decode($content));
        $errors = $validator->validate($object);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (count($errors)) {
            $humanized_errors = Validator::humanize($errors);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode($humanized_errors));
        } else {
            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent('{"id": ' . Objects::oid . '}');
        }

        return $response;
    }
    
    public function update(Request $request, ValidatorInterface $validator) {
        $oid = $request->query->get('oid');
        $content = $request->getContent();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($oid, Objects::$stubObjects)) {
            $json_decodedContent = json_decode($content);
            $object = new MObject($json_decodedContent);
            $errors = $validator->validate($object);
        
            if (count($errors)) {
                $humanized_errors = Validator::humanize($errors);
                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
                $response->setContent(json_encode($humanized_errors));
            } else {
                $response->setStatusCode(Response::HTTP_OK);
                $response->setContent('"Ok"');
            }
        } else {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->setContent('"Not Found"');
        }

        return $response;
    }
}