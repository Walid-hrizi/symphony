<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Job;
use App\Entity\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class JobController extends AbstractController
{
      
    /**
     * @Route("/", name="job")
     */
    public function index()
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }
    /**
    * @Route("/acceuil", name="acceuil")
    */
    public function acceuil(Request $request)
    { //return $this->redirectToRoute('job');
        //return  $this->render('job/acceuil.html.twig');
        //https://127.0.0.1:8000/acceuil?nom=walid%20hrizi
        $nom=$request->query->get('nom');
        return $this->render('job/acceuil.html.twig',['nom'=>$nom]); 
    }
    /**
    * @Route("/voir/{id}", name="voir",requirements={"id"="\d+"})
        */
   /**public  function voir ($id)
    {
        //return new Response("Details du job ayant l'id:".$id);
    return $this->render('job/voir.html.twig',['x' => $id]);
  
    }*/
    public function voir($id){
        $repository = $this->getDoctrine()->getManager()->getRepository(job::Class);
        $job = $repository -> find ($id);
        if (null === $job) {
        throw new NotFoundHttpException("Le job ayant l'id ".$id."
        n'existe pas.");
        }
        return $this->render('job/voir.html.twig', ['job' => $job]);
       }
    /**
    * @Route("/ajouter", name="ajouter")
    */
 /**public function ajouter(){
    return $this->render('job/ajouter.html.twig'); 
}  */
 /**public function ajouter()
    {
        
        $job= new job();
        $job -> setTitle('Developpeur symfony');
        $job -> setCompany('SENSIO LAB');
        $job -> setDescription('nous recherchon un developpeur symfony');
        $job -> setIsActivated(1);
        $job -> setExpiresAt(new \DateTime());
        $job -> setEmail('walidhrizi5@gmail.com');

        $em = $this -> getDoctrine() -> getManager ();
        $em -> persist($job);
        $em -> flush();
        return $this ->render ('job/ajouter.html.twig',['job' => $job]);



    }*/
     /**public function ajouter()
    {
        $date='2021-01-01';
        $em =$this-> getDoctrine()-> getManager ();

        $job1 = $em-> getRepository(job::Class)->find(10);
        $job1 ->setExpiresAt(new \Datetime($date));
        $job1 ->setTitle('helloooo');
       


        $job2= new job();
        $job2 -> setTitle('Architecte');
        $job2 -> setCompany('Sousse Imobilier');
        $job2 -> setDescription('nous recherchon un Architecte ');
        $job2 -> setIsActivated(1);
        $job2 -> setExpiresAt(new \Datetime());
        $job2 -> setEmail('walidhrrrrizi5@gmail.com');

         $em -> persist($job2);
        $em -> flush();
        return $this ->render ('job/ajouter.html.twig',array('id1' => $job1->getId(),'id2'=>$job2->getId()));

    }*/
    /**public function ajouter()
    {
        $job= new job();
        $job -> setTitle('nnnnnnnnnnnnnnnnnnnnnnn');
        $job -> setCompany('gafsa Imobilier');
        $job -> setDescription('nous recherchon un Architecte ');
        $job -> setIsActivated(1);
        $job -> setExpiresAt(new \Datetime());
        $job -> setEmail('nidha@gmail.com');
        $image = new image();
        $image -> setUrl ('../../images/img-01.png');
        $image -> setAlt ('nidhal chaaben');
        $job -> setImage($image);
        $em =$this-> getDoctrine()-> getManager ();

         $em -> persist($job);
        $em -> flush();

        return $this ->render ('job/ajouter.html.twig',array('job' => $job));

    }*/
    public function ajouter(Request $request)
     {
        $job= new job();
        $form = $this -> createFormBuilder($job)
         -> add ('Title', TextType::class)
         -> add ('Company', TextType::class)
         -> add ('Description', TextareaType::class)
         -> add ('IsActivated', CheckboxType::class)
         -> add ('ExpiresAt', DateType::class)
         -> add ('Email', TextType::class)
         -> add ('Save', SubmitType::class)
         -> getForm();
if ($request->isMethod('POST'))
{$form ->handleRequest($request);

if($form->isvalid())
{
    $em = $this->getDoctrine()->getManager();
    $em ->persist($job);
    $em->flush();
    $request ->getSession() ->getFlashBag() ->add('notice', 'job bien enrgsitré.');
    return $this-> redirectToRoute('voir',array('id'=>$job->getId()));

}

}
         return $this ->render ('job/ajouter.html.twig',array('form' => $form -> createView()));

    }
    /**
    * @Route("/modifier/{id}", name="modifier", requirements={"id"="\d+"})
    */
public function modifier($id){
    return $this->render('job/modifier.html.twig',['id' => $id,]);
}
    /**
    * @Route("/supprimer/{id}", name="supprimer",requirements={"id"="\d+"})
    */
    public function supprimer($id){
        return $this->render('job/supprimer.html.twig',['id' => $id,]);
    }
    /**
     * @Route("/base" )
      */
      public function base(){
          return $this->render('base.html.twig');
      }
     /**
     * @Route("/layout" )
      */
      public function layout(){
        return $this->render('job/layout.html.twig');
    }
    public function menu()
    { $listJobs= array(
        ['id' => 1 , 'intitule' => 'Developpeur web'],
        ['id' => 2 , 'intitule' => 'Docteur'],
        ['id' => 3 , 'intitule' => 'Journaliste']
    );
        return $this -> render ('job/menu.html.twig',[
            'listJobs' => $listJobs,
        ]);
    }
    
   
}
