<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Stubs\Objects;
use App\Entity\Obj;
use App\Common\Validator;

/**
 * @Route("/api", name="object_api")
 */
class ObjectController
{
    /**
     * @Route("/objects", name="objects", methods={"GET"})
     */
    public function get(Request $request)
    {
        $oid = $request->query->get('oid');
        $object;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($oid, Objects::$stubObjects)) {
            $object = Objects::$stubObjects[$oid];
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
     * @Route("/objects", name="objects_add", methods={"POST"})
     */
    public function add(Request $request, ValidatorInterface $validator) {
        $content = $request->getContent();
        $object = new Obj(json_decode($content));
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
            $result = '{"id": ' . Objects::oid . '}';
        }

        $response->setContent($result);
        $response->setStatusCode($code);

        return $response;
    }
    /**
     * @Route("/objects", name="objects_update", methods={"PUT"})
     */
    public function update(Request $request, ValidatorInterface $validator) {
        $oid = $request->query->get('oid');
        $content = $request->getContent();
        $result;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($oid, Objects::$stubObjects)) {
            $json_decodedContent = json_decode($content);
            $object = new Obj($json_decodedContent);
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
     * @Route("/objects", name="objects_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $oid = $request->query->get('oid');
        $content;
        $code;
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        if (array_key_exists($oid, Objects::$stubObjects)) {
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