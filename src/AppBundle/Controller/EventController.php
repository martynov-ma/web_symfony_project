<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    /**
     * @Route("/events", name="events_list")
     */
    public function indexAction()
    {
        $events = $this->getDoctrine()->getRepository("AppBundle:Event")->findAll();
        return $this->render('AppBundle:Event:index.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * @Route("/event/{id}")
     */
    public function showAction($id, Request $request)
    {
        $event=$this->getDoctrine()->getRepository("AppBundle:Event")->find($id);
        return $this->render('AppBundle:Event:show.html.twig', array(
            'event' => $event
        ));
    }

    /**
     * @Route("/events/create")
     */
    public function createAction(Request $request)
    {
        $event = new Event;
        $form = $this->createFormBuilder($event)
            ->add('name',TextType::class, array(
                "label" => "Название:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('type',TextType::class, array(
                "label" => "Тип:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('description',TextareaType::class, array(
                "label" => "Описание:",
                "attr" => array(
                    'class' => 'form-control',
                    'rows' => '5'
                )
            ))
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                "label" => "Дата проведения:",
                "attr" => array(
                    'class' => 'form-control',
                    'style' => 'width: 200px;'
                )
            ))
            ->add('place',EntityType::class, array(
                "class" =>"AppBundle:Place",
                "label" => "Место проведения:",
                "choice_label" => "name",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('poster',TextType::class, array(
                "label" => "Имя файла для постера:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('submit',SubmitType::class, array(
                "label" => "Добавить"
            ))->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $type = $form['type']->getData();
            $description = $form['description']->getData();
            $date = $form['date']->getData();
            $poster = $form['poster']->getData();

            $event->setName($name);
            $event->setType($type);
            $event->setDescription($description);
            $event->setDate($date);
            $event->setPoster($poster);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("events_list");
        }
        return $this->render('AppBundle:Event:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/events/edit/{id}")
     */
    public function editAction($id, Request $request)
    {
        $event=$this->getDoctrine()->getRepository("AppBundle:Event")->find($id);
        $form=$this->createFormBuilder($event)
            ->add('name',TextType::class, array(
                "label" => "Название:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('type',TextType::class, array(
                "label" => "Тип:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('description',TextareaType::class, array(
                "label" => "Описание:",
                "attr" => array(
                    'class' => 'form-control',
                    'rows' => '5'
                )
            ))
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                "label" => "Дата проведения:",
                "attr" => array(
                    'class' => 'form-control',
                    'style' => 'width: 200px;'
                )
            ))
            ->add('place',EntityType::class, array(
                "class" =>"AppBundle:Place",
                "label" => "Место проведения:",
                "choice_label" => "name",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('poster',TextType::class, array(
                "label" => "Имя файла для постера:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('submit',SubmitType::class, array(
                "label" => "Применить"
            ))->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $type = $form['type']->getData();
            $description = $form['description']->getData();
            $date = $form['date']->getData();
            $poster = $form['poster']->getData();

            $event->setName($name);
            $event->setType($type);
            $event->setDescription($description);
            $event->setDate($date);
            $event->setPoster($poster);

            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("events_list");
        }
        return $this->render('AppBundle:Event:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/events/delete/{id}")
     */
    public function deleteAction($id)
    {
        $event = $this->getDoctrine()->getRepository("AppBundle:Event")->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute("events_list");
    }

}
