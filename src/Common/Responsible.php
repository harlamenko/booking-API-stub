<?php

namespace App\Common;

use Symfony\Component\HttpFoundation\Response;

class Responsible
{
    
    static function formNotFound() {
        return Responsible::response('Not Found', Response::HTTP_NOT_FOUND);
    }
    
    static function formBadRequest($errors) {
        return Responsible::response(Validator::humanize($errors), Response::HTTP_BAD_REQUEST);
    }
    
    static function response($data, $status = Response::HTTP_OK, $headers = [])
    {
        $response = new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($status);

        return $response;
    }

    static function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}