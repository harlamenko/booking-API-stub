<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Taxi;
use App\Common\Validator;
use App\Repository\TaxiRepository;

/**
 * @Route("/api", name="taxi_api")
 */
class TaxiController extends AbstractController
{
    /**
     * @Route("/taxi", name="taxi", methods={"GET"})
     */
    public function getTaxi(Request $request, TaxiRepository $taxiRepository)
    {
        $aid = $request->query->get('aid');
        $taxi = $taxiRepository->find($aid);
        if (!$taxi) {
            return $this->response('Not Found', Response::HTTP_NOT_FOUND);
        }            
        return $this->response($taxi);
    }
    /**
     * @Route("/taxi", name="taxi_add", methods={"POST"})
     */
    public function addTaxi(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        TaxiRepository $taxiRepository
    ) {
        $request = $this->transformJsonBody($request);
        $taxi = new Taxi();
        $taxi->setName($request->get('name'));
        $taxi->setType($request->get('type'));
        $taxi->setSits($request->get('sits'));
        $taxi->setLuggage($request->get('luggage'));
        $taxi->setService($request->get('meeting'));
        $taxi->setMeeting($request->get('service'));
        $taxi->setPrice($request->get('price'));

        $errors = $validator->validate($taxi);

        if (count($errors)) {
            return $this->response(Validator::humanize($errors), Response::HTTP_BAD_REQUEST);
        }            

        $entityManager->persist($taxi);
        $entityManager->flush();
    
        return $this->response(['id' => $taxi->getId()]);
    }
    /**
     * @Route("/taxi", name="taxi_update", methods={"PUT"})
     */
    public function updateTaxi(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        TaxiRepository $taxiRepository
    ) {
        $aid = $request->query->get('aid');
        $taxi = $taxiRepository->find($aid);
        if (!$taxi) {
            return $this->response('Not Found', Response::HTTP_NOT_FOUND);
        }

        $request = $this->transformJsonBody($request);
        $taxi->setName($request->get('name'));
        $taxi->setType($request->get('type'));
        $taxi->setSits($request->get('sits'));
        $taxi->setLuggage($request->get('luggage'));
        $taxi->setService($request->get('meeting'));
        $taxi->setMeeting($request->get('service'));
        $taxi->setPrice($request->get('price'));

        $errors = $validator->validate($taxi);
        if (count($errors)) {
            return $this->response(Validator::humanize($errors), Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();
    
        return $this->response('Ok');
    }
    /**
     * @Route("/taxi", name="taxi_delete", methods={"DELETE"})
     */
    public function deleteTaxi(
        Request $request,
        EntityManagerInterface $entityManager,
        TaxiRepository $taxiRepository
    ) {
        $aid = $request->query->get('aid');
        $taxi = $taxiRepository->find($aid);
        if (!$taxi) {
            return $this->response('Not Found', Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($taxi);
        $entityManager->flush();

        return $this->response('Ok');
    }

    public function response($data, $status = Response::HTTP_OK, $headers = [])
    {
        $response = new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode($status);

        return $response;
    }

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}