<?php

namespace HL\FantasiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FantasiaBundle:Default:index.html.twig', array('mensaje'=>'Inicio'));
    }
	
	public function loginAction()
    {
        return $this->render('FantasiaBundle:Default:index.html.twig', array('mensaje'=>'Iniciar sesión'));
    }

    public function logoutAction()
    {
        return $this->render('FantasiaBundle:Default:index.html.twig', array('mensaje'=>'Iniciar sesion'));
    }
	
	public function dumpAction()
    {
        $dbhost=$this->container->getParameter('database_host');
        $dbname=$this->container->getParameter('database_name');
        $dbuser=$this->container->getParameter('database_user');
        $dbpass=$this->container->getParameter('database_password');
        $pathActual = getcwd() . '/backups/'; //trae el path actual 
        $backup_file = $pathActual . 'Fantasia-@-Fecha-' . date("d-m-Y") . '-@-Hora-'.(date("H-i-s")).'.sql';

        $command = "mysqldump --user=$dbuser --password=$dbpass $dbname > $backup_file";

        system($command,$output);

        if (($output =='1')){  //Si se creó con exito el BackUp
            return $this->render('FantasiaBundle:Default:exitodump.html.twig', array('pathactual'=>$pathActual));            
            }                         
        else { //Si no se creó el BackUp
            return $this->render('FantasiaBundle:Default:errordump.html.twig', array());
            }                         
    }
}
