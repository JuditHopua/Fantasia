<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\AsignacionMarcaModelo;
use HL\FantasiaBundle\Form\AsignacionMarcaModeloType;
use Ps\PdfBundle\Annotation\Pdf;
use PHPPdf\Core\FacadeBuilder;

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
        $document = new AsignacionMarcaModelo();
        $form = $this->createCreateForm($document);
        $form->handleRequest($request);

        if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$document->upload();
            $em->persist($document);
            $em->flush();

            return $this->redirect($this->generateUrl('abertura'));
        }

        return array(
            'entity' => $document,
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

        $form->add('submit', 'submit', array('label' => 'Crear'));

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
            throw $this->createNotFoundException('No se pudo encontrar la abertura seleccionada');
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
            throw $this->createNotFoundException('No se pudo encontrar la abertura seleccionada');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
          //  'delete_form' => $deleteForm->createView(),
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
            'action' => $this->generateUrl('abertura_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
	
		
		
        $form->add('submit', 'submit', array('label' => 'Modificar'));
		$form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));
		
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

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('abertura'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a AsignacionMarcaModelo entity.
     *
     * @Route("/{id}/delete", name="abertura_delete")
     * @Template("FantasiaBundle:AsignacionMarcaModelo:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($id);

		if (!$entity) {
            throw $this->createNotFoundException('No se pudo encontrar la abertura seleccionada');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('abertura'));
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
        return $this->createFormBuilder(array('id' => $id))

            ->add('id', 'hidden')

            ->getForm()
        ;
    }
	
	/**
	* @Pdf()
	*/
	public function imprimirAction()
	{
		$em=$this->getDoctrine()->getManager();
		$entities= $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->findAll();
		$formato=$this->get('request')->get('_format');
		return $this->render(sprintf('FantasiaBundle:AsignacionMarcaModelo:imprimirlistado.%s.twig', $formato), array('entities'=>$entities));
	}
   
}
