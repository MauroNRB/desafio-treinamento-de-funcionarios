<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    protected $entity;
    protected $formType;
    protected $path;
    protected $entityType;

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository($this->entityType);
        $entities = $repository->findAll();

        return $this->render("{$this->path}/index.html.twig", array(
            'entities' => $entities,
            'typePage' => $this->path
        ));
    }

    public function createAction(Request $request)
    {
        $form = $this->createForm($this->formType, $this->entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($this->entity);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Criado com sucesso.');

            return $this->redirectToRoute($this->path . '_list');
        }

        return $this->render("{$this->path}/create.html.twig", array(
            'form' => $form->createView(),
            'typePage' => $this->path
        ));
    }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));
        $form = $this->createForm($this->formType, $this->entity);

        $form->handleRequest($request);

        if ($request->isMethod('PUT')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entity = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($this->entity);
                $em->flush();

                $this->get('session')->getFlashBag()->set('success', 'Atualizado com sucesso.');

                return $this->redirectToRoute($this->path . '_list');
            }
        }

        return $this->render("{$this->path}/update.html.twig", array(
            'form' => $form->createView(),
            'entity' => $this->entity,
            'typePage' => $this->path
        ));
    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));

        $em->remove($this->entity);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Deletado com sucesso.');

        return $this->redirectToRoute($this->path . '_list');
    }

    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->entity = $em->find($this->entityType, $request->get('id'));

        return $this->render("{$this->path}/show.html.twig", array(
            $this->path => $this->entity,
            'typePage' => $this->path
        ));
    }

    public function indexApiAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository($this->entityType);
            $entities = $repository->findAll();

            $arr = array();
            foreach($entities as $entity) {
                $arr[] = $entity->getArrayEntity();
            }

            return new JsonResponse($arr, 200);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function showApiAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $this->entity = $em->find($this->entityType, $request->get('id'));
            return new JsonResponse($this->entity->getArrayEntity(), 200);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function createApiAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $arr = json_decode($request->getContent(), true);

            $this->create($em, $arr);

            $em->persist($this->entity);
            $em->flush();

            return new JsonResponse(array('msg' => 'Criado com Sucesso'), 201);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function updateApiAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $this->entity = $em->find($this->entityType, $request->get('id'));
            $arr = json_decode($request->getContent(), true);

            $this->update($em, $arr);

            $em->persist($this->entity);
            $em->flush();

            return new JsonResponse(array('msg' => 'Atualizado com Sucesso'), 201);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }

    public function deleteApiAction(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $this->entity = $em->find($this->entityType, $request->get('id'));

            $em->remove($this->entity);
            $em->flush();

            return new JsonResponse(array('msg' => 'Deletado com Sucesso'), 201);
        } catch (\Throwable $e) {
            return new JsonResponse(array(
                'msg' => 'Error interno'
            ), 500);
        }
    }
}
