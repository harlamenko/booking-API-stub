<?php
namespace App\Controller\Object;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Stubs\Objects;

class GetController
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
}