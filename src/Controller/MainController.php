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

    public function linkPeopleToCoaching(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();

            if ($request->isMethod('GET')) {
                $peoples = $em->getRepository(People::class)->findAll();
                $coachings = $em->getRepository(Coaching::class)->findAll();

                $arrPeoples = array();
                $arrCoachings = array();

                /** @var PeopleInterface $people */
                foreach ($peoples as $people) {
                    $arrPeoples[] = $people->getArrayBaseEntity();
                }

                /** @var CoachingInterface $coaching */
                foreach ($coachings as $coaching) {
                    $arrCoachings[] = $coaching->getArrayEntity();
                }

                return $this->render('general/linkPeopleToCoaching.html.twig', array(
                    'typePage' => 'index',
                    'coachings' => $arrCoachings,
                    'peoples' => $arrPeoples
                ));
            } else if ($request->isMethod('POST')) {
                try {
                    $arr = json_decode($request->getContent(), true);

                    if (empty($arr['people']) || empty($arr['coaching'])) {
                        return new JsonResponse(array('msg' => $this->messageError), 201);
                    }

                    /** @var PeopleInterface $people */
                    $people = $em->find(People::class, $arr['people']);

                    /** @var CoachingInterface $coaching */
                    $coaching = $em->find(Coaching::class, $arr['coaching']);
                    $coaching->addPeople($people);

                    $em->persist($coaching);
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

    public function findPeoples(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $peoples = $em->getRepository(People::class)->findAll();

            $arrPeoples = array();

            /** @var PeopleInterface $people */
            foreach ($peoples as $people) {
                $coachingsTotal = $people->getCoachings()->count();
                $count = 0;

                $salas = 'Sem treinamento ainda vinculado';

                /** @var CoachingInterface $coaching */
                foreach ($people->getCoachings() as $coaching) {
                    $count++;

                    $name = $coaching->getRoom()->getName();;
                    if ($coachingsTotal === 1 || $count == 1) {
                        $salas = $name;
                    } else {
                        $salas .= ' - ' . $name;
                    }
                }


                $arrPeoples[] = array(
                    'Nome' => $people->getFullName(),
                    'Salas' => $salas,
                    'Cafeteria' => $people->getCafeteria() instanceof CafeteriaInterface ? $people->getCafeteria()->getName() : 'Sem cafeteria ainda vinculado',
                );
            }

            return $this->render('general/find.html.twig', array(
                'typePage' => 'index',
                'entities' => $arrPeoples,
                'title' => 'Consulte uma pessoa cadastrada',
                'placeholder' => 'Filtrar por nomes das pessoas',
                'field' => 'Nome',
            ));
        } catch (\Throwable $e) {}

        $this->get('session')->getFlashBag()->set('error', 'Não ao consultar.');
        return $this->redirectToRoute('index');
    }

    public function findRooms(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $rooms = $em->getRepository(Room::class)->findAll();

            $arrRooms = array();

            /** @var RoomInterface $room */
            foreach ($rooms as $room) {
                $peoples = 'Sem pessoas ainda vinculado';
                $coaching = $room->getCoaching();

                $count = 0;
                $totalPeoples = $coaching->getPeoples()->count();

                /** @var PeopleInterface $people */
                foreach ($coaching->getPeoples() as $people) {
                    $count++;
                    $name = $people->getFullName();;
                    if ($totalPeoples === 1 || $count == 1) {
                        $peoples = $name;
                    } else {
                        $peoples .= "\n\r" . $name;
                    }
                }


                $arrRooms[] = array(
                    'Nome' => $room->getName(),
                    'Pessoas' => $peoples,
                );
            }

            return $this->render('general/find.html.twig', array(
                'typePage' => 'index',
                'entities' => $arrRooms,
                'title' => 'Consulte as pessoas alocadas em uma sala',
                'placeholder' => 'Filtrar por nomes das salas',
                'field' => 'Nome',
            ));
        } catch (\Throwable $e) {}

        $this->get('session')->getFlashBag()->set('error', 'Não ao consultar.');
        return $this->redirectToRoute('index');
    }

    public function findCafeterias(Request $request): Response
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $cafeterias = $em->getRepository(Cafeteria::class)->findAll();

            $arrCafeterias = array();

            /** @var CafeteriaInterface $cafeteria */
            foreach ($cafeterias as $cafeteria) {
                $peoples = 'Sem pessoas ainda vinculado';

                $count = 0;
                $totalPeoples = $cafeteria->getPeoples()->count();

                /** @var PeopleInterface $people */
                foreach ($cafeteria->getPeoples() as $people) {
                    $count++;
                    $name = $people->getFullName();;
                    if ($totalPeoples === 1 || $count == 1) {
                        $peoples = $name;
                    } else {
                        $peoples .= "\n\r" . $name;
                    }
                }


                $arrCafeterias[] = array(
                    'Nome' => $cafeteria->getName(),
                    'Pessoas' => $peoples,
                );
            }

            return $this->render('general/find.html.twig', array(
                'typePage' => 'index',
                'entities' => $arrCafeterias,
                'title' => 'Consulte as pessoas em espaços de cafés',
                'placeholder' => 'Filtrar por nomes das cafeterias',
                'field' => 'Nome',
            ));
        } catch (\Throwable $e) {
            echo $e->getMessage() . '<br>';
            echo $e->getLine() . '<br>';
            echo $e->getFile() . '<br>';
            exit();
        }

        $this->get('session')->getFlashBag()->set('error', 'Não ao consultar.');
        return $this->redirectToRoute('index');
    }
}