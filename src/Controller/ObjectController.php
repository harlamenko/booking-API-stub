<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Obj;
use App\Common\Validator;
use App\Common\Responsible;
use App\Repository\ObjRepository;

/**
 * @Route("/api", name="object_api")
 */
class ObjectController extends AbstractController
{
    /**
     * @Route("/objects", name="objects", methods={"GET"})
     */
    public function getObj(Request $request, ObjRepository $objRepository)
    {
        $oid = $request->query->get('oid');
        $obj = $objRepository->find($oid);
        
        if (!$obj) {
            return Responsible::formNotFound();
        }

        return Responsible::response($obj);
    }
    /**
     * @Route("/objects", name="objects_add", methods={"POST"})
     */
    public function addObj(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        ObjRepository $objRepository
    ) {
        $request = Responsible::transformJsonBody($request);
        $obj = new Obj();

        $obj->setPhoneNumber($request->get('phone_number'));
        $obj->setObjectName($request->get('object_name'));
        $obj->setHostName($request->get('host_name'));
        $obj->setCountry($request->get('country'));
        $obj->setCity($request->get('city'));
        $obj->setStreet($request->get('street'));
        $obj->setStars($request->get('stars'));
        $obj->setRoom($request->get('room'));
        $obj->setGuestsCount($request->get('guests_count'));
        $obj->setPrice($request->get('price'));
        $obj->setHouseNumber($request->get('house_number'));

        $errors = $validator->validate($obj);

        if (count($errors)) {
            return Responsible::formBadRequest($errors);
        }            

        $entityManager->persist($obj);
        $entityManager->flush();
    
        return Responsible::response(['id' => $obj->getId()]);
    }
    /**
     * @Route("/objects", name="objects_update", methods={"PUT"})
     */
    public function updateObj(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        ObjRepository $objRepository
    ) {
        $oid = $request->query->get('oid');
        $obj = $objRepository->find($oid);
        if (!$obj) {
            return Responsible::formNotFound();
        }

        $request = Responsible::transformJsonBody($request);

        $obj->setPhoneNumber($request->get('phone_number'));
        $obj->setObjectName($request->get('object_name'));
        $obj->setHostName($request->get('host_name'));
        $obj->setCountry($request->get('country'));
        $obj->setCity($request->get('city'));
        $obj->setStreet($request->get('street'));
        $obj->setStars($request->get('stars'));
        $obj->setRoom($request->get('room'));
        $obj->setGuestsCount($request->get('guests_count'));
        $obj->setPrice($request->get('price'));
        $obj->setHouseNumber($request->get('house_number'));
        $errors = $validator->validate($obj);
        if (count($errors)) {
            return Responsible::formBadRequest($errors);
        }
        
        $entityManager->flush();
    
        return Responsible::response('Ok');
    }
    /**
     * @Route("/objects", name="objects_delete", methods={"DELETE"})
     */
    public function deleteObj(
        Request $request,
        EntityManagerInterface $entityManager,
        ObjRepository $objRepository
    ) {
        $oid = $request->query->get('oid');
        $obj = $objRepository->find($oid);
        if (!$obj) {
            return Responsible::formNotFound();
        }

        $entityManager->remove($obj);
        $entityManager->flush();

        return Responsible::response('Ok');
    }
}