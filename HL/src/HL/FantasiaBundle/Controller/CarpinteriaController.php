<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Carpinteria;
use HL\FantasiaBundle\Entity\AsignacionMarcaModelo;
use HL\FantasiaBundle\Form\CarpinteriaType;

/**
 * Carpinteria controller.
 *
 * @Route("/carpinteria")
 */
class CarpinteriaController extends Controller
{

    /**
     * Lists all Carpinteria entities.
     *
     * @Route("/", name="carpinteria")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Carpinteria')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Carpinteria entity.
     *
     * @Route("/", name="carpinteria_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Carpinteria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Carpinteria();
		
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('carpinteria'));
        }
		
        return array(
			
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Carpinteria entity.
     *
     * @param Carpinteria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Carpinteria $entity)
    {
        $form = $this->createForm(new CarpinteriaType(), $entity, array(
            'action' => $this->generateUrl('carpinteria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Carpinteria entity.
     *
     * @Route("/new", name="carpinteria_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Carpinteria();
        $form   = $this->createCreateForm($entity);
		$em = $this->getDoctrine()->getManager();
		$aberturas = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->findAll();
        return array(
			'aberturas' => $aberturas,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Carpinteria entity.
     *
     * @Route("/{id}", name="carpinteria_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Carpinteria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carpinteria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Carpinteria entity.
     *
     * @Route("/{id}/edit", name="carpinteria_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Carpinteria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro la carpintería');
        }

        $editForm = $this->createEditForm($entity);
       // $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
           // 'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Carpinteria entity.
    *
    * @param Carpinteria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carpinteria $entity)
    {
        $form = $this->createForm(new CarpinteriaType(), $entity, array(
            'action' => $this->generateUrl('carpinteria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));
		$form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Carpinteria entity.
     *
     * @Route("/{id}", name="carpinteria_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Carpinteria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Carpinteria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carpinteria entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('carpinteria'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Carpinteria entity.
     *
     * @Route("/{id}/delete", name="carpinteria_delete")
     * @Template("FantasiaBundle:Carpinteria:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Carpinteria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carpinteria entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('carpinteria'));
    }

    /**
     * Creates a form to delete a Carpinteria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))

            ->add('id', 'hidden')

            ->getForm()
        ;
    }
}
