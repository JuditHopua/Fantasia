<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Vidrio;
use HL\FantasiaBundle\Form\VidrioType;
use Ps\PdfBundle\Annotation\Pdf;
use PHPPdf\Core\FacadeBuilder;

/**
 * Vidrio controller.
 *
 * @Route("/vidrio")
 */
class VidrioController extends Controller
{

    /**
     * Lists all Vidrio entities.
     *
     * @Route("/", name="vidrio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FantasiaBundle:Vidrio')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Vidrio entity.
     *
     * @Route("/", name="vidrio_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Vidrio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Vidrio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		if ($this::noExisteVidrio($entity)) {
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				return $this->redirect($this->generateUrl('vidrio'));
			} else {
				return array(
					'mensaje' => null,
					'entity' => $entity,
					'form'   => $form->createView(),
					);
			}
		}

        return array(
			'mensaje' => 'Ya existe el vidrio. Ingrese uno diferente.',
            'entity' => $entity,
            'form'   => $form->createView(),
			);
    }

    /**
     * Creates a form to create a Vidrio entity.
     *
     * @param Vidrio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vidrio $entity)
    {
        $form = $this->createForm(new VidrioType(), $entity, array(
            'action' => $this->generateUrl('vidrio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Vidrio entity.
     *
     * @Route("/new", name="vidrio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vidrio();
        $form   = $this->createCreateForm($entity);

        return array(
			'mensaje' => null,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
	
    /**
     * Displays a form to edit an existing Vidrio entity.
     *
     * @Route("/{id}/edit", name="vidrio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Vidrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el vidrio seleccionado');
        }
		 $_SESSION['entity_original']= $entity;
        $editForm = $this->createEditForm($entity);
       
        return array(
			'mensaje' =>null,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Vidrio entity.
    *
    * @param Vidrio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vidrio $entity)
    {
        $form = $this->createForm(new VidrioType(), $entity, array(
            'action' => $this->generateUrl('vidrio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));
		$form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('onclick'=>'history.back()','formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));
        
		return $form;
    }
    /**
     * Edits an existing Vidrio entity.
     *
     * @Route("/{id}", name="vidrio_update")
     * @Method("PUT")
     * @Template("FantasiaBundle:Vidrio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Vidrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el vidrio seleccionado');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
		if ($this::noExisteClienteEdit($_SESSION['entity_original'], $entity)) {
			if ($editForm->isValid()) {
				$em->flush();
				return $this->redirect($this->generateUrl('vidrio'));
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
			'mensaje' => 'Ya existe el vidrio. Ingrese uno diferente.',
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
	
    /**
     * Deletes a Vidrio entity.
     *
     * @Route("/{id}/delete", name="vidrio_delete")
     * @Template("FantasiaBundle:Vidrio:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Vidrio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar el vidrio seleccionado');
            }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('vidrio'));
    }

    /**
     * Creates a form to delete a Vidrio entity by id.
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
	
	/**
	* @Pdf()
	* @Route("/{listado}.{_format}", name="vidrio_imprimir")
	*/
	public function imprimirAction()
	{
		$em=$this->getDoctrine()->getManager();
		$entities= $em->getRepository('FantasiaBundle:Vidrio')->findAll();
		$formato=$this->get('request')->get('_format');
		return $this->render(sprintf('FantasiaBundle:Vidrio:imprimirlistado.%s.twig', $formato), array('entities'=>$entities));
	}
	
	private function noExisteCliente ($entity)
	{
        $em = $this->getDoctrine()->getManager();
        $tipo = $entity->getTipo();
		$query = $em->createQuery("SELECT v FROM FantasiaBundle:Vidrio v
                                   WHERE v.tipo = '$tipo' ");
        $cliente = $query->getResult();
        if (empty($cliente)) { 
            return true;
        } else {
            return false;
			}
    }
	
   private function noExisteClienteEdit ($entity_original, $entity)
	{
	    $tipo_original = $entity_original->getTipo();
		$tipo = $entity->getTipo();
		if ($tipo<>$tipo_original) { 
            return $this::noExisteVidrio($entity);
		} else {  
            return true;
			}
	}
}
