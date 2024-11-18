<?php

namespace App\Controller;

use App\Entity\Cafeteria;
use App\Entity\CafeteriaInterface;
use App\Entity\Coaching;
use App\Entity\CoachingInterface;
use App\Entity\People;
use App\Entity\PeopleInterface;
use App\Entity\Room;
use App\Entity\RoomInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends BaseController
{
    protected $messageSuccess = <<<HTML
        <div class="alert alert-success">
            <h4 class="alert-heading">Sucesso</h4>
            Vinculado com sucesso.
        </div>
HTML;

    protected $messageError = <<<HTML
        <div class="alert alert-danger">
            <h4 class="alert-heading">Erro</h4>
            Não foi possível vincular.
        </div>
HTML;


    public function indexAction(Request $request): Response
    {
        return $this->render('index.html.twig', array(
            'typePage' => 'index'
        ));
    }

    public function linkPeopleToCafeteria(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();

            if ($request->isMethod('GET')) {
                $peoples = $em->getRepository(People::class)->findAll();
                $cafeterias = $em->getRepository(Cafeteria::class)->findAll();

                $arrPeoples = array();
                $arrCafeterias = array();

                /** @var PeopleInterface $people */
                foreach ($peoples as $people) {
                    $arrPeoples[] = $people->getArrayBaseEntity();
                }

                /** @var CafeteriaInterface $cafeteria */
                foreach ($cafeterias as $cafeteria) {
                    $arrCafeterias[] = $cafeteria->getArrayEntity();
                }

                return $this->render('general/linkPeopleToCafeteria.html.twig', array(
                    'typePage' => 'index',
                    'cafeterias' => $arrCafeterias,
                    'peoples' => $arrPeoples
                ));
            } else if ($request->isMethod('POST')) {
                try {
                    $arr = json_decode($request->getContent(), true);

                    if (empty($arr['people']) || empty($arr['cafeteria'])) {
                        return new JsonResponse(array('msg' => $this->messageError), 201);
                    }

                    /** @var PeopleInterface $people */
                    $people = $em->find(People::class, $arr['people']);

                    /** @var CafeteriaInterface $cafeteria */
                    $cafeteria = $em->find(Cafeteria::class, $arr['cafeteria']);
                    $cafeteria->addPeople($people);

                    $em->persist($cafeteria);
                    $em->flush();

                    $msg = $this->messageSuccess;
                } catch (\Throwable $e) {
                    $msg = $this->messageError;
                }

                return new JsonResponse(array('msg' => $msg), 201);
            }
        } catch (\Throwable $e) {}

        $this->get('session')->getFlashBag()->set('error', 'Não foi possível vincular.');
        return $this->redirectToRoute('index');
    }

    public function linkRoomToCoaching(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();

            if ($request->isMethod('GET')) {
                $rooms = $em->getRepository(Room::class)->findAll();

                $arrRooms = array();

                /** @var RoomInterface $room */
                foreach ($rooms as $room) {
                    $arrRooms[] = $room->getArrayBaseEntity();
                }

                return $this->render('general/linkRoomToCoaching.html.twig', array(
                    'typePage' => 'index',
                    'rooms' => $arrRooms
                ));
            } else if ($request->isMethod('POST')) {
                try {
                    $arr = json_decode($request->getContent(), true);

                    if (empty($arr['room']) && empty($arr['coaching'])) {
                        return new JsonResponse(array('msg' => $this->messageError), 201);
                    }

                    /** @var RoomInterface $room */
                    $room = $em->find(Room::class, $arr['room']);

                    /** @var CoachingInterface $entity */
                    $entity = new Coaching();
                    $entity->setRoom($room);
                    $entity->setRotation((int) $arr['coaching']);

                    $em->persist($entity);
                    $em->flush();

                    $msg = $this->messageSuccess;
                } catch (\Throwable $e) {
                    $msg = $this->messageError;
                }

                return new JsonResponse(array('msg' => $msg), 201);
            }
        } catch (\Throwable $e) {}

        $this->get('session')->getFlashBag()->set('error', 'Não foi possível vincular.');
        return $this->redirectToRoute('index');
    }
}