<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class PlaceController extends Controller
{
    /**
     * @Route("/places", name="places_list")
     */
    public function indexAction()
    {
        $places = $this->getDoctrine()->getRepository("AppBundle:Place")->findAll();
        return $this->render('AppBundle:Place:index.html.twig', array(
            'places' => $places
        ));
    }

    /**
     * @Route("/places/create")
     */
    public function createAction(Request $request)
    {
        $place = new Place;
        $form = $this->createFormBuilder($place)
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
            ->add('address',TextType::class, array(
                "label" => "Адрес:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('image',TextType::class, array(
                "label" => "Имя файла для изображения:",
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
            $address = $form['address']->getData();
            $image = $form['image']->getData();

            $place->setName($name);
            $place->setType($type);
            $place->setDescription($description);
            $place->setAddress($address);
            $place->setImage($image);

            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            return $this->redirectToRoute("places_list");
        }
        return $this->render('AppBundle:Place:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/places/edit/{id}")
     */
    public function editAction($id, Request $request)
    {
        $place=$this->getDoctrine()->getRepository("AppBundle:Place")->find($id);
        $form=$this->createFormBuilder($place)
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
            ->add('address',TextType::class, array(
                "label" => "Адрес:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('image',TextType::class, array(
                "label" => "Имя файла для изображения:",
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
            $address = $form['address']->getData();
            $image = $form['image']->getData();

            $place->setName($name);
            $place->setType($type);
            $place->setDescription($description);
            $place->setAddress($address);
            $place->setImage($image);

            $em=$this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            return $this->redirectToRoute("places_list");
        }
        return $this->render('AppBundle:Place:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/places/delete/{id}")
     */
    public function deleteAction($id)
    {
        $place = $this->getDoctrine()->getRepository("AppBundle:Place")->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($place);
        $em->flush();
        return $this->redirectToRoute("places_list");
    }

}
