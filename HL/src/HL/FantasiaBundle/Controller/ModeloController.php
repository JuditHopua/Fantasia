<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Modelo;
use HL\FantasiaBundle\Form\ModeloType;

/**
 * Modelo controller.
 *
 * @Route("/modelo")
 */
class ModeloController extends Controller
{

    /**
     * Lists all Modelo entities.
     *
     * @Route("/", name="modelo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Modelo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Modelo entity.
     *
     * @Route("/", name="modelo_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Modelo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Modelo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		if ($this::noExisteModelo($entity)) {
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				return $this->redirect($this->generateUrl('modelo'));
			}
			else {
				return array(
					'mensaje' => null,
					'entity' => $entity,
					'form'   => $form->createView(),
				);
				}
		}
		return array(
		    'mensaje' => 'Ya existe el modelo. Ingrese uno diferente.',
            'entity' => $entity,
            'form'   => $form->createView(),
			);
    }

    /**
     * Creates a form to create a Modelo entity.
     *
     * @param Modelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Modelo $entity)
    {
        $form = $this->createForm(new ModeloType(), $entity, array(
            'action' => $this->generateUrl('modelo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Modelo entity.
     *
     * @Route("/new", name="modelo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Modelo();
        $form   = $this->createCreateForm($entity);

        return array(
			'mensaje' => null,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Modelo entity.
     *
     * @Route("/{id}", name="modelo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Modelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Modelo entity.
     *
     * @Route("/{id}/edit", name="modelo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Modelo')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el modelo seleccionado');
        }
		$_SESSION['entity_original']= $entity;
        $editForm = $this->createEditForm($entity);
      
        return array(
			'mensaje' => null,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Modelo entity.
    *
    * @param Modelo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Modelo $entity)
    {
        $form = $this->createForm(new ModeloType(), $entity, array(
            'action' => $this->generateUrl('modelo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=>array('onclick'=>'return confirmar()')));
		
		return $form;
    }
    /**
     * Edits an existing Modelo entity.
     *
     * @Route("/{id}", name="modelo_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Modelo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Modelo')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modelo entity.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
		if ($this::noExisteModeloEdit($_SESSION['entity_original'], $entity)) {
			if ($editForm->isValid()) {
				$em->flush();
				return $this->redirect($this->generateUrl('modelo'));
				}
			else {
				return array(
					'mensaje' => null,
					'entity'      => $entity,
					'edit_form'   => $editForm->createView(),
					);
			}
		}
        return array(
			'mensaje' => 'Ya existe el modelo. Ingrese uno diferente.',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Modelo entity.
     *
     * @Route("/{id}/delete", name="modelo_delete")
     * @Template("FantasiaBundle:Modelo:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Modelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el modelo seleccionado');
        }

        $em->remove($entity);
        $em->flush();
 
        return $this->redirect($this->generateUrl('modelo'));
    }

    /**
     * Creates a form to delete a Modelo entity by id.
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
	
	private function noExisteModelo($entity)
	{
        $em = $this->getDoctrine()->getManager();
        $nombre = $entity->getNombre();
		$query = $em->createQuery("SELECT m FROM FantasiaBundle:Modelo m 
        WHERE m.nombre = '$nombre' ");
        $modelo = $query->getResult();
        if (empty($modelo)) {
            return true;
		} else {
            return false;}
    }
	
    private function noExisteModeloEdit ($entity_original, $entity)
	{
	    $nombre_original = $entity_original->getNombre();
		$nombre = $entity->getNombre();
		if ($nombre<>$nombre_original) { 
            return $this::noExisteModelo($entity);
		} else {
			return true;
			}
    }       
}
?>