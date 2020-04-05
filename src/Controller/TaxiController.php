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
use App\Common\Responsible;

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
            return Responsible::formNotFound();
        }            
        return Responsible::response($taxi);
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
        $request = Responsible::transformJsonBody($request);
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
            return Responsible::formBadRequest($errors);
        }            

        $entityManager->persist($taxi);
        $entityManager->flush();
    
        return Responsible::response(['id' => $taxi->getId()]);
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
            return Responsible::formNotFound();
        }

        $request = Responsible::transformJsonBody($request);
        $taxi->setName($request->get('name'));
        $taxi->setType($request->get('type'));
        $taxi->setSits($request->get('sits'));
        $taxi->setLuggage($request->get('luggage'));
        $taxi->setService($request->get('meeting'));
        $taxi->setMeeting($request->get('service'));
        $taxi->setPrice($request->get('price'));

        $errors = $validator->validate($taxi);
        if (count($errors)) {
            return Responsible::formBadRequest($errors);
        }

        $entityManager->flush();
    
        return Responsible::response('Ok');
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
            return Responsible::formNotFound();
        }

        $entityManager->remove($taxi);
        $entityManager->flush();

        return Responsible::response('Ok');
    }

}