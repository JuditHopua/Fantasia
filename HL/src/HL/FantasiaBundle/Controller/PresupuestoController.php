<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Presupuesto;
use HL\FantasiaBundle\Form\PresupuestoType;

/**
 * Presupuesto controller.
 *
 * @Route("/presupuesto")
 */
class PresupuestoController extends Controller
{

    /**
     * Lists all Presupuesto entities.
     *
     * @Route("/", name="presupuesto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Presupuesto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Presupuesto entity.
     *
     * @Route("/", name="presupuesto_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Presupuesto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Presupuesto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('presupuesto'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Presupuesto entity.
     *
     * @param Presupuesto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Presupuesto $entity)
    {
        $form = $this->createForm(new PresupuestoType(), $entity, array(
            'action' => $this->generateUrl('presupuesto_create'),
            'method' => 'POST',
        ));
		$url=$this->generateUrl('carpinteria_new');
        $form->add('submit', 'submit', array('label' => 'Crear'));
		$form->add('button', 'submit', array('label' => 'Agregar Carpinteria','attr'=>array('formaction'=>$url,'formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Presupuesto entity.
     *
     * @Route("/new", name="presupuesto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Presupuesto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Presupuesto entity.
     *
     * @Route("/{id}", name="presupuesto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Presupuesto entity.
     *
     * @Route("/{id}/edit", name="presupuesto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
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
    * Creates a form to edit a Presupuesto entity.
    *
    * @param Presupuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Presupuesto $entity)
    {
        $form = $this->createForm(new PresupuestoType(), $entity, array(
            'action' => $this->generateUrl('presupuesto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Presupuesto entity.
     *
     * @Route("/{id}", name="presupuesto_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Presupuesto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('presupuesto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Presupuesto entity.
     *
     * @Route("/{id}", name="presupuesto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Presupuesto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('presupuesto'));
    }

    /**
     * Creates a form to delete a Presupuesto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('presupuesto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
