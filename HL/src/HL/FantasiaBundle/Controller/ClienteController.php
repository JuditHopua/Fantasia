<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Cliente;
use HL\FantasiaBundle\Form\ClienteType;

/**
 * Cliente controller.
 *
 * @Route("/cliente")
 */
class ClienteController extends Controller
{

    /**
     * Lists all Cliente entities.
     *
     * @Route("/", name="cliente")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Cliente')->findAll();

		return array(
            'entities' => $entities,
			
        );
    }
    /**
     * Creates a new Cliente entity.
     *
     * @Route("/", name="cliente_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Cliente:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Cliente();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		if ($this::noExisteCliente($entity)){
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				return $this->redirect($this->generateUrl('cliente'));
			}
			else {
				return array(
				'mensaje'=>null,
				'entity' => $entity,
				'form'   => $form->createView(),
				);
			}
		}
		else {
        return array(
		    'mensaje' => 'Ya existe el cliente',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
		}
    }

    /**
     * Creates a form to create a Cliente entity.
     *
     * @param Cliente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Cliente entity.
     *
     * @Route("/new", name="cliente_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Cliente();
        $form   = $this->createCreateForm($entity);

        return array(
			'mensaje' => null,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Cliente entity.
     *
     * @Route("/{id}", name="cliente_show")
     * @Method("GET")
     * @Template()
     */
     public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cliente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Cliente entity.
     *
     * @Route("/{id}/edit", name="cliente_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Cliente')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el cliente');
        }

        $editForm = $this->createEditForm($entity);
		$_SESSION['entity_original']=$entity;
        return array(
			'mensaje' => null,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Cliente entity.
    *
    * @param Cliente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cliente $entity)
    {
        $form = $this->createForm(new ClienteType(), $entity, array(
            'action' => $this->generateUrl('cliente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=>array('onclick'=>'return confirmar()')));

        return $form;
    }
    /**
     * Edits an existing Cliente entity.
     *
	 * @Route("/{id}", name="cliente_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Cliente:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Cliente')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el cliente');
        }
		
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
		if ($this::noExisteClienteEdit($_SESSION['entity_original'], $entity)){
			if ($editForm->isValid()) {
				$em->flush();
				return $this->redirect($this->generateUrl('cliente'));
			}
			else {
				return array(
					'mensaje'=> null,
					'entity' => $entity,
					'edit_form'   => $editForm->createView(),
				);
			}
		}
		else {
			return array(
				'mensaje' => 'Ya existe el cliente. Ingrese uno diferente.',
				'entity' => $entity,
				'edit_form'   => $editForm->createView(),
			);
		}
    }
   /**
     * Deletes a Cliente entity.
     *
     * @Route("/{id}/delete", name="cliente_delete")
     * @Template("FantasiaBundle:Cliente:index.html.twig")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Cliente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar al cliente');
        }

        $em->remove($entity);
        $em->flush();
       
		return $this->redirect($this->generateUrl('cliente'));
    }

    /**
     * Creates a form to delete a Cliente entity by id.
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
	
	private function noExisteCliente($entity){
		$em = $this->getDoctrine()->getManager();
		$nombre=$entity->getNombre();
		$apellido=$entity->getApellido();
		$email=$entity->getEmail();
		$domicilio=$entity->getDomicilio();
		
		$query=$em->createQuery("SELECT c FROM FantasiaBundle:Cliente c WHERE c.nombre='$nombre' AND c.apellido='$apellido' AND c.email='$email'
								AND c.domicilio='$domicilio'");
		$cliente=$query->getResult();
		if (empty($cliente)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	private function noExisteClienteEdit($entity_original, $entity)
	{
		$nombre=$entity->getNombre();
		$apellido=$entity->getApellido();
		$email=$entity->getEmail();
		$domicilio=$entity->getDomicilio();
		
		$nombre_original=$entity_original->getNombre();
		$apellido_original=$entity_original->getApellido();
		$email_original=$entity_original->getEmail();
		$domicilio_original=$entity_original->getDomicilio();
		
		if (($nombre<>$nombre_original) or ($apellido<>$apellido_original) or ($email<>$email_original) or ($domicilio<>$domicilio_original)) {
			return $this::noExisteCliente($entity);
		}
		else {
			return true;
		}
	}
}

