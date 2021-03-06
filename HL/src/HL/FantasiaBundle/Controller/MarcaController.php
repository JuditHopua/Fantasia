<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Marca;
use HL\FantasiaBundle\Form\MarcaType;

/**
 * Marca controller.
 *
 * @Route("/marca")
 */
class MarcaController extends Controller
{

    /**
     * Lists all Marca entities.
     *
     * @Route("/", name="marca")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Marca')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Marca entity.
     *
     * @Route("/", name="marca_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Marca:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Marca();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		if ($this::noExisteMarca($entity)) {
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				return $this->redirect($this->generateUrl('marca'));
			} else {
				return array(
					'mensaje' => null,
					'entity' => $entity,
					'form'   => $form->createView(),
				   );
				}
        }
        return array(
			'mensaje' => 'Ya existe la marca. Ingrese una diferente.',
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Marca entity.
     *
     * @param Marca $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Marca $entity)
    {
        $form = $this->createForm(new MarcaType(), $entity, array(
            'action' => $this->generateUrl('marca_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Marca entity.
     *
     * @Route("/new", name="marca_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Marca();
        $form   = $this->createCreateForm($entity);
        return array(
			'mensaje' => null,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Marca entity.
     *
     * @Route("/{id}", name="marca_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Marca')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Marca entity.
     *
     * @Route("/{id}/edit", name="marca_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Marca')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la marca seleccionada');
        }
		$_SESSION['entity_original']= $entity;
        $editForm = $this->createEditForm($entity);

        return array(
			'mensaje'     => null,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Marca entity.
    *
    * @param Marca $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Marca $entity)
    {
        $form = $this->createForm(new MarcaType(), $entity, array(
            'action' => $this->generateUrl('marca_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=>array('onclick'=>'return confirmar()')));
		
        return $form;
    }
    /**
     * Edits an existing Marca entity.
     *
     * @Route("/{id}", name="marca_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Marca:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Marca')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la marca seleccionada');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

       if ($this::noExisteMarcaEdit($_SESSION['entity_original'], $entity)) {
			if ($editForm->isValid()) {
				$em->flush();
				return $this->redirect($this->generateUrl('marca'));
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
			'mensaje' => 'Ya existe la marca. Ingrese una diferente.',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a Marca entity.
     *
     * @Route("/{id}/delete", name="marca_delete")
     * @Template("FantasiaBundle:Marca:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Marca')->find($id);
       
	   if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marca entity.');
		}
            
		$em->remove($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('marca'));
    }

    /**
     * Creates a form to delete a Marca entity by id.
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
	
	public function imprimirAction()
	{
		$em=$this->getDoctrine()->getManager();
		$entities= $em->getRepository('FantasiaBundle:Marca')->findAll();
		$formato=$this->get('request')->get('_format');
		return $this->render(sprintf('FantasiaBundle:Marca:imprimirlistado.pdf.twig', $formato), array('entities'=>$entities));
	}
	
	private function noExisteMarca($entity)
	{
        $em = $this->getDoctrine()->getManager();
        $nombre = $entity->getNombre();
		$query = $em->createQuery("SELECT m FROM FantasiaBundle:Marca m 
        WHERE m.nombre = '$nombre' ");
        $marca = $query->getResult();
        if (empty($marca)) {
            return true;
		} else {
            return false;}
    }
	
    private function noExisteMarcaEdit ($entity_original, $entity)
	{
	    $nombre_original = $entity_original->getNombre();
		$nombre = $entity->getNombre();
		if ($nombre<>$nombre_original) { 
            return $this::noExisteMarca($entity);
		} else {
			return true;
			}
    }       
}
