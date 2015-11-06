<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\AsignacionMarcaModelo;
use HL\FantasiaBundle\Form\AsignacionMarcaModeloType;

/**
 * AsignacionMarcaModelo controller.
 *
 * @Route("/asignacionmarcamodelo")
 */
class AsignacionMarcaModeloController extends Controller
{

    /**
     * Lists all AsignacionMarcaModelo entities.
     *
     * @Route("/", name="asignacionmarcamodelo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new AsignacionMarcaModelo entity.
     *
     * @Route("/", name="asignacionmarcamodelo_create")
     * @Method("POST")
     * @Template("FantasiaBundle:AsignacionMarcaModelo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new AsignacionMarcaModelo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('asignacionmarcamodelo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a AsignacionMarcaModelo entity.
     *
     * @param AsignacionMarcaModelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AsignacionMarcaModelo $entity)
    {
        $form = $this->createForm(new AsignacionMarcaModeloType(), $entity, array(
            'action' => $this->generateUrl('asignacionmarcamodelo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AsignacionMarcaModelo entity.
     *
     * @Route("/new", name="asignacionmarcamodelo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new AsignacionMarcaModelo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a AsignacionMarcaModelo entity.
     *
     * @Route("/{id}", name="asignacionmarcamodelo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AsignacionMarcaModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing AsignacionMarcaModelo entity.
     *
     * @Route("/{id}/edit", name="asignacionmarcamodelo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AsignacionMarcaModelo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a AsignacionMarcaModelo entity.
    *
    * @param AsignacionMarcaModelo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AsignacionMarcaModelo $entity)
    {
        $form = $this->createForm(new AsignacionMarcaModeloType(), $entity, array(
            'action' => $this->generateUrl('asignacionmarcamodelo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AsignacionMarcaModelo entity.
     *
     * @Route("/{id}", name="asignacionmarcamodelo_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:AsignacionMarcaModelo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AsignacionMarcaModelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('asignacionmarcamodelo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a AsignacionMarcaModelo entity.
     *
     * @Route("/{id}", name="asignacionmarcamodelo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AsignacionMarcaModelo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('asignacionmarcamodelo'));
    }

    /**
     * Creates a form to delete a AsignacionMarcaModelo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asignacionmarcamodelo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
