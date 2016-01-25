<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HL\FantasiaBundle\Entity\Presupuesto;
use HL\FantasiaBundle\Form\PresupuestoType;
use Ps\PdfBundle\Annotation\Pdf;
use PHPPdf\Core\FacadeBuilder;
use Swift_Attachment;

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
	
		foreach($entities as $entity)
		{
			$id=$entity->getId();
			$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
			$carpinterias = $query->getResult();
			$entity->setMontoTotalCarpinterias($this->calcularMonto($carpinterias));
		}
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
			$_SESSION['id_presup']=$entity->getId();
			$_SESSION['editando']=0;
            return $this->redirect($this->generateUrl('carpinteria_new'));
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
    
		$form->add('agregar', 'submit', array('label' => 'Agregar Carpinteria'));

        return $form;
    }

    /**
     * Displays a form to create a new Presupuesto entity.
     *
     * @Route("/new", name="presupuesto_new")
    
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
     * @Route("/{id}/crear", name="presupuesto_crear")
     * @Method("GET")
     * @Template()
     */
    public function crearAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
        }
		
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
					
        $carpinterias = $query->getResult();
		$entity->setMontoTotalCarpinterias($this->calcularMonto($carpinterias));
		$_SESSION['id_presup']=$id;
        $crearForm = $this->createCrearForm($entity, false);

        return array(
			'carpinterias' => $carpinterias,
            'entity'      => $entity,
            'crear_form'   => $crearForm->createView(),
        );
    }

    /**
    * Creates a form to crear a Presupuesto entity.
    *
    * @param Presupuesto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCrearForm(Presupuesto $entity, $boolean)
    {
        $form = $this->createForm(new PresupuestoType(), $entity, array(
            'action' => $this->generateUrl('presupuesto_creando', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
		if ($boolean) {
        $form->add('costoEnvio','money', array('currency'=>'$$$'));
		$form->add('costoColocacion','money', array('currency'=>'$$$'));
		$form->add('plazoEntrega');
		$form->add('crear', 'submit', array('label' => 'Crear'));
		$form->add('agregar', 'submit', array('label' => 'Agregar Carpinteria','attr'=>array('style'=>'display:none')));
		$form->add('finalizar', 'submit', array('label' => 'Finalizar','attr'=>array('style'=>'display:none')));
		}
		else {
			$form->add('costoEnvio','money', array('currency'=>'$$$', 'label_attr'=>array('style'=>'display:none'),'attr'=>array('style'=>'display:none', 'disabled'=>true)));
			$form->add('costoColocacion','money', array('currency'=>'$$$', 'label_attr'=>array('style'=>'display:none'),'attr'=>array('style'=>'display:none', 'disabled'=>true)));
			$form->add('plazoEntrega', 'text', array('label_attr'=>array('style'=>'display:none'),'attr'=>array('style'=>'display:none', 'disabled'=>true))); 
			$form->add('crear', 'submit', array('label' => 'Crear','attr'=>array('style'=>'display:none')));
			$form->add('agregar', 'submit', array('label' => 'Agregar Carpinteria'));
			$form->add('finalizar', 'submit', array('label' => 'Finalizar'));
		}
        return $form;
    }
    /**
     *
     * @Route("/{id}/creando", name="presupuesto_creando")
     * @Method("PUT")
     * @Template("FantasiaBundle:Presupuesto:crear.html.twig")
     */
    public function creandoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
        }

        $crearForm = $this->createCrearForm($entity, false);
        $crearForm->handleRequest($request);
	
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
					
		$carpinterias = $query->getResult();
		if ($crearForm->isValid()) {
			if ($crearForm->get('finalizar')->isClicked()){
			$crearForm = $this->createCrearForm($entity, true);
			
			return array(
			'carpinterias' => $carpinterias,
            'entity'      => $entity,
            'crear_form'   => $crearForm->createView(),
			);
				
			} elseif ($crearForm->get('crear')->isClicked()){
				$entity->setMontoTotalCarpinterias($this->calcularMonto($carpinterias));
				$em->flush();
				return $this->redirect($this->generateUrl('presupuesto'));
			} elseif ($crearForm->get('agregar')->isClicked()) {
				$_SESSION['editando']=0;	
				$em->flush();
				return $this->redirect($this->generateUrl('carpinteria_new'));
			}
     }

       return array(
			'carpinterias' => $carpinterias,
            'entity'      => $entity,
            'crear_form'   => $crearForm->createView(),
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
		
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
					
        $carpinterias = $query->getResult();
		$entity->setMontoTotalCarpinterias($this->calcularMonto($carpinterias));
		$_SESSION['id_presup']=$id;
        $editForm = $this->createEditForm($entity);

        return array(
			'carpinterias' => $carpinterias,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
		
        $form->add('costoEnvio','money', array('currency'=>'$$$'));
		$form->add('costoColocacion','money', array('currency'=>'$$$'));
		$form->add('plazoEntrega');	
		$form->add('agregar', 'submit', array('label' => 'Agregar Carpinteria'));
		$form->add('finalizar', 'submit', array('label' => 'Modificar'));
		//$form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('formaction'=>'../../presupuesto','formmethod'=>'GET','formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));
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

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
	
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
					
		$carpinterias = $query->getResult();
		if ($editForm->isValid()) {
			if ($editForm->get('finalizar')->isClicked()){			
				$entity->setMontoTotalCarpinterias($this->calcularMonto($carpinterias));
				$em->flush();
				return $this->redirect($this->generateUrl('presupuesto'));
			} elseif ($editForm->get('agregar')->isClicked()) {
				
            $em->flush();
			$_SESSION['editando']=1;
            return $this->redirect($this->generateUrl('carpinteria_new'));
			}
     }

       return array(
			'carpinterias' => $carpinterias,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
	
    /**
     * Deletes a Presupuesto entity.
     *
     * @Route("/{id}/delete", name="presupuesto_delete")
     * @Template("FantasiaBundle:Presupuesto:index.html.twig")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presupuesto entity.');
        }

        $em->remove($entity);
        $em->flush();
        
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
        return $this->createFormBuilder(array('id' => $id))

            ->add('id', 'hidden')

            ->getForm()
        ;
    }
	
	public function calcularMonto($carpinterias){
		$montoTotalCarpinterias=0;
		foreach($carpinterias as $carpinterias)
				{
					$ancho = $carpinterias->getAncho();
					$alto = $carpinterias->getAlto();
					$premarco = $carpinterias->getPremarco();
					$contramarco = $carpinterias->getContramarco();
					$cantidad = $carpinterias->getCantidad();
					$asignacion = $carpinterias->getAsignacion();
					$precioxML=$asignacion->getPrecioxML();
					$vidrio=$carpinterias->getVidrio();
					$precioxm2=$vidrio->getPrecioxm2();
					$montoTotalCarpinterias=$montoTotalCarpinterias+((($alto+$ancho)*2*$precioxML)*$cantidad)+((($alto*$ancho)*$precioxm2)*$cantidad);
					if ($premarco==1){
						$precioPremarco=$asignacion->getPrecioPremarcoML();
						$montoTotalCarpinterias=$montoTotalCarpinterias+((($alto+$ancho)*2*$precioPremarco)*$cantidad);
						}
					if ($contramarco==1){
						$precioContramarco=$asignacion->getPrecioContramarcoML();
						$montoTotalCarpinterias=$montoTotalCarpinterias+((($alto+$ancho)*2*$precioContramarco)*$cantidad);
						}
				}
				
		return $montoTotalCarpinterias;
	}
	
	/**
     * @Route("/{id}/mail", name="presupuesto_mail")
     */
    public function mailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		

        $entity = $em->getRepository('FantasiaBundle:Presupuesto')->find($id);
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 
					
		$carpinterias = $query->getResult();
		
		//$file= 'C:\wamp\www\Symfony2\src\HL\FantasiaBundle\Resources\views\Presupuesto\imprimirlistado.pdf.twig';

		$message = \Swift_Message::newInstance()
			->setSubject('Presupuesto | Fantasia SA')
			->setFrom('fantasia.sa.16@gmail.com')
			->setTo('zurdolarrondo@hotmail.com')
			//->setBody ('ejemplo')
			->setBody ($this->renderView(
            'FantasiaBundle:Presupuesto:imprimirlistado.pdf.twig', array('entity'=>$entity, 'carpinterias'=>$carpinterias)
			), 'text/html');
			//->attach(Swift_Attachment::fromPath($file));
			
    $this->get('mailer')->send($message);
   
	return $this->redirect($this->generateUrl('presupuesto'));
	}
	
	/**
	* @Pdf()
	 * @Route("/{id}/{listado}.{_format}", name="presupuesto_imprimir")
	*/
	public function imprimirAction($id)
	{
		$em=$this->getDoctrine()->getManager();
		$entity= $em->getRepository('FantasiaBundle:Presupuesto')->find($id);
		$query = $em->createQuery("SELECT c
                           FROM FantasiaBundle:Carpinteria c WHERE c.presupuesto=$id"); 			
		$carpinterias = $query->getResult();
		$formato=$this->get('request')->get('_format');
		return $this->render(sprintf('FantasiaBundle:Presupuesto:imprimirlistado.%s.twig', $formato), array('entity'=>$entity, 'carpinterias'=>$carpinterias));
	}

}
