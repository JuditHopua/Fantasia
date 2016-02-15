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
use Symfony\Component\HttpFoundation\Response;

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
	 * @Route("/", name="carpinteria_create")
     * @Method("POST")
     * @Template("FantasiaBundle:Carpinteria:new.html.twig")
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Carpinteria();
		
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
			if (isset($_SESSION['asignacion'])){
			 $em = $this->getDoctrine()->getManager();
			$presup = $em->getRepository('FantasiaBundle:Presupuesto')->find($_SESSION['id_presup']);
			$entity->setPresupuesto($presup);
			$asign = $em->getRepository('FantasiaBundle:AsignacionMarcaModelo')->find($_SESSION['asignacion']);
			$entity->setAsignacion($asign);
			unset($_SESSION['asignacion']);
            $em->persist($entity);
            $em->flush();
			if ($_SESSION['editando'] == 0){
				return $this->redirect($this->generateUrl('presupuesto_crear', array('id'=>$_SESSION['id_presup'])));
				}
				elseif ($_SESSION['editando'] == 1)  {
					return $this->redirect($this->generateUrl('presupuesto_edit', array('id'=>$_SESSION['id_presup'])));
				}
        }
		}
		$_SESSION['asignacion']=null;
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery("SELECT DISTINCT m.id, m.nombre FROM FantasiaBundle:AsignacionMarcaModelo a, FantasiaBundle:Modelo m
									WHERE m.id=a.modelo ORDER BY m.nombre ASC"); 
		$modelos = $query->getResult();
		
        return array(
			'mensaje' =>'Todos los campos deben ser completados y válidos',
			'modelos' => $modelos,
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

        $form->add('submit', 'submit', array('label' => 'Agregar Carpintería'));//,'attr'=>array('formaction'=>$_SERVER['HTTP_REFERER'])));

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
		$query = $em->createQuery("SELECT DISTINCT m.id, m.nombre FROM FantasiaBundle:AsignacionMarcaModelo a, FantasiaBundle:Modelo m
									WHERE m.id=a.modelo ORDER BY m.nombre ASC"); 
		$modelos = $query->getResult();

        return array(
			'mensaje' =>'',
			'modelos' => $modelos,
            'entity' => $entity,
            'form'   => $form->createView(),
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

        $form->add('submit', 'submit', array('label' => 'Modificar', 'attr'=>array('onclick'=>'return confirmar()')));
		
		$form->add('button', 'submit', array('label' => 'Volver la lista','attr'=>array('onclick'=>'history.back()','formnovalidate'=>'formnovalidate','class'=>'btn btn-primary')));
		
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

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

           if ($_SESSION['editando'] == 0){
				return $this->redirect($this->generateUrl('presupuesto_crear', array('id'=>$_SESSION['id_presup'])));
				}
				elseif ($_SESSION['editando'] == 1)  {
					return $this->redirect($this->generateUrl('presupuesto_edit', array('id'=>$_SESSION['id_presup'])));
				}
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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


        if ($_SESSION['editando'] == 0){
				return $this->redirect($this->generateUrl('presupuesto_crear', array('id'=>$_SESSION['id_presup'])));
				}
				elseif ($_SESSION['editando'] == 1)  {
					return $this->redirect($this->generateUrl('presupuesto_edit', array('id'=>$_SESSION['id_presup'])));
				}
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
	
	/**                                                                                   
	 * @Route("/marcas", name="carpinteria_marcas")
	 * @Method("POST")
	 */
	 public function marcasAction()
    {
        $em = $this->getDoctrine()->getManager();
		
		$request = $this->get('request');
		
		$id_modelo = $request->get('id_modelo');
        
		$html = '<option value=”” disabled selected>Seleccione marca...</option>';
		$query = $em->createQuery("SELECT ma FROM FantasiaBundle:AsignacionMarcaModelo a, FantasiaBundle:Marca ma
						WHERE ma.id=a.marca and a.modelo=$id_modelo ORDER BY ma.nombre ASC"); 
		$marcas = $query->getResult();
		foreach($marcas as $marcas){
				$id=$marcas->getId();
				$nombre=$marcas->getNombre();
				$html .= '<option value="'.$id.'">'.$nombre.'</option>';
			}
		 return new Response($html);
    }

	/**                                                                                   
	 * @Route("/datos", name="carpinteria_datos")
	
	 */
	 public function datosAction()
    {
        $em = $this->getDoctrine()->getManager();
		$html = '';
		$request = $this->get('request');
		
		$id_modelo = $request->get('id_modelo');
        $id_marca = $request->get('id_marca');
		
		$query = $em->createQuery("SELECT a FROM FantasiaBundle:AsignacionMarcaModelo a
						WHERE a.marca=$id_marca and a.modelo=$id_modelo");
						
		$datos = $query->getResult();
		
		$_SESSION['asignacion'] = $datos[0]->getId();	
		
		$html = '<thead>
				  <tr>
					
					<th id="datosthtd">Precio metro lineal</th>
					<th id="datosthtd">Precio premarco</th>
					<th id="datosthtd">Precio contramarco</th>
				 </tr>
					</thead>
					<tbody>
						<tr>
							
							<td id="datosthtd">$'.$datos[0]->getPrecioxML().'</td>
							<td id="datosthtd">$'.$datos[0]->getPrecioPremarcoML().'</td>
							<td id="datosthtd">$'.$datos[0]->getPrecioContramarcoML().'</td>
						</tr>
					</tbody>';
			
		 return new Response($html);
    }
}
