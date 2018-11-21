<?php

namespace CovoiturageBundle\Controller;

use CovoiturageBundle\Entity\Reclamation;
use CovoiturageBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CovoiturageBundle\Entity\Annonce;
use CovoiturageBundle\Entity\AnnonceCovoiturage;
use CovoiturageBundle\Entity\AnnonceCo;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class DefaultController extends Controller
{
    /**
     * @Route("/ahmed")
     */
    public function indexAction()
    {
        return $this->render('CovoiturageBundle:Default:index.html.twig');
    }


    /**
     * @Route("/api/annonceall", name="Annonce_Getall")
     * @Method({"GET"})
     */
    public function GetAllAnnonceAction()
    {
        $articles = $this->getDoctrine()->getRepository('CovoiturageBundle:AnnonceCo')->findAll();
        $data = $this->get('jms_serializer')->serialize($articles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/annoncesearch/{gouvernorat}", name="Annonce_Gouvernorat")
     * @Method({"GET"})
     */
    public function GetAnnonceParGouvernoratAction($gouvernorat)
    {    $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT   p 
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernorat = :annonce OR p.gouvernoratdest = :annonce'
        )->setParameter('annonce', $gouvernorat
        );;
        $annoncegouvernorat = $query->getResult();
        $data = $this->get('jms_serializer')->serialize($annoncegouvernorat, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/annonces/{id}/{date}", name="annonce_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request,$id,$date)
    {
        $data = $request->getContent();
           $annonce = new AnnonceCo();

        $em = $this->getDoctrine()->getManager();
        $annonce = $this->get('jms_serializer')->deserialize($data, 'CovoiturageBundle\Entity\AnnonceCo', 'json');
        $user=$em->getRepository("CovoiturageBundle:User")->find($id);
        $annonce->setUser($user);
        $annonce->setDate(new \DateTime());
        $annonce->setDatepublication(new \DateTime($date));

        $em->persist($annonce);
        $em->flush();
        $annonceback = $this->get('jms_serializer')->serialize($annonce, 'json');

        $response = new Response($annonceback);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/delete/{id}", name="delete_annonce")
     * @Method({"DELETE"})
     */
    public function DeleteAction($id)
    {


        $em = $this->getDoctrine()->getManager();

        $annoncetodelete=$em->getRepository("CovoiturageBundle:AnnonceCo")->find($id);
        $data = $this->get('jms_serializer')->serialize($annoncetodelete, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $em->remove($annoncetodelete);
        $em->flush();



        return $response;

    }

    /**
     * @Route("/api/login", name="login")
     * @Method({"POST"})
     */
    public function LoginAction(Request $request)
    {
        $data = $request->getContent();
        $userr = new User();
        $userr = $this->get('jms_serializer')->deserialize($data, 'CovoiturageBundle\Entity\User', 'json');
        $username=$userr->getUsername();
        $password=$userr->getPassword();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT   count(p.id)
    FROM CovoiturageBundle:User p
    WHERE p.username = :username AND p.password = :password  '
        )->setParameter('username',$username
        )->setParameter('password',$password
            )
        ;;
        $count = $query->getSingleScalarResult();

      if ($count==1)
      {
          $query = $em->createQuery(
              'SELECT   p
              FROM CovoiturageBundle:User p
             WHERE p.username = :username AND p.password = :password  '
          )->setParameter('username',$username
          )->setParameter('password',$password
          )
          ;;
          $loggeduser = $query->getResult();
          $session = $this->get('jms_serializer')->serialize($loggeduser, 'json');
          $response = new Response($session);
          $response->headers->set('Content-Type', 'application/json');

      }
      else
      {
          $user= new User();
          $user->setUsername("");
          $user->setPassword("");

          $data = $this->get('jms_serializer')->serialize($user, 'json');

          $response = new Response($data);
          $response->headers->set('Content-Type', 'application/json');



    }
      return $response;

    }

    /**
     * @Route("/api/annoncedemande/", name="Annonce_Demande")
     * @Method({"GET"})
     */
    public function GetAnnonceDemandeAction()
    {    $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT   p 
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.type = :annonce'
        )->setParameter('annonce', 'Demande'
        );;
        $annoncedemande = $query->getResult();
        $data = $this->get('jms_serializer')->serialize($annoncedemande, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/annonceoffre/", name="Annonce_Offre")
     * @Method({"GET"})
     */
    public function GetAnnonceOffreAction()
    {    $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT   p 
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.type = :annonce'
        )->setParameter('annonce', 'Offre'
        );;
        $annonceOffre = $query->getResult();
        $data = $this->get('jms_serializer')->serialize($annonceOffre, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/annonceuser/{id}", name="Annonce_User")
     * @Method({"GET"})
     */
    public function GetAnnonceUserAction($id)
    {    $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("CovoiturageBundle:User")->find($id);

        $query = $em->createQuery(
            'SELECT   p 
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.user = :user'
        )->setParameter('user', $user
        );;
        $annonceuser = $query->getResult();
        $data = $this->get('jms_serializer')->serialize($annonceuser, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }


    /**
     * @Route("/api/modifierannonce/{id}/{date}", name="annonce_modifier")
     * @Method({"PUT"})
     */
    public function ModifierAnnonceAction(Request $request,$id,$date)
    {
        $data = $request->getContent();
        $annonce = new AnnonceCo();

        $em = $this->getDoctrine()->getManager();
        $annonce = $this->get('jms_serializer')->deserialize($data,'CovoiturageBundle\Entity\AnnonceCo', 'json');
       $titre=$annonce->getTitre();
       $description=$annonce->getDescription();
       $gouvernorat=$annonce->getGouvernorat();
        $gouvernoratdest=$annonce->getGouvernoratdest();
       $type=$annonce->getType();
        $fumeur=$annonce->getFumeur();
        $bagage=$annonce->getBagage();
        $clim=$annonce->getClim();
        $multiville=$annonce->getMultiville();
        $prix=$annonce->getPrix();
        $adressedebut=$annonce->getAdressedebut();
        $adressedestination=$annonce->getAdressedestination();

        $annoncetomodify=$em->getRepository("CovoiturageBundle:AnnonceCo")->find($id);
        $annoncetomodify->setTitre($titre);
        $annoncetomodify->setDatepublication(new \DateTime($date));
        $annoncetomodify->setDescription($description);
        $annoncetomodify->setGouvernorat($gouvernorat);
        $annoncetomodify->setGouvernoratdest($gouvernoratdest);
        $annoncetomodify->setType($type);
        $annoncetomodify->setFumeur($fumeur);
        $annoncetomodify->setClim($clim);
        $annoncetomodify->setBagage($bagage);
        $annoncetomodify->setMultiville($multiville);
        $annoncetomodify->setPrix($prix);
        $annoncetomodify->setAdressedebut($adressedebut);
        $annoncetomodify->setAdressedestination($adressedestination);









        $em->persist($annoncetomodify);
        $em->flush();
        $annonceback = $this->get('jms_serializer')->serialize($annoncetomodify, 'json');

        $response = new Response($annonceback);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/reclamation/{id}", name="reclamation_create")
     * @Method({"POST"})
     */
    public function createReclamationAction(Request $request,$id)
    {
        $data = $request->getContent();
        $recalamtion = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $recalamtion = $this->get('jms_serializer')->deserialize($data, 'CovoiturageBundle\Entity\Reclamation', 'json');
        $user=$em->getRepository("CovoiturageBundle:User")->find($id);
        $recalamtion->setUser($user);
        $recalamtion->setDate(new \DateTime());

        $em->persist($recalamtion);
        $em->flush();
        $reclamationback = $this->get('jms_serializer')->serialize($recalamtion, 'json');

        $response = new Response($reclamationback);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/api/register", name="register")
     * @Method({"POST"})
     */
    public function RegisterAction(Request $request)
    {
        $data = $request->getContent();
        $user = new User();
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('jms_serializer')->deserialize($data, 'CovoiturageBundle\Entity\User', 'json');
        $em->persist($user);
        $em->flush();
        $userback = $this->get('jms_serializer')->serialize($user, 'json');
        $response = new Response($userback);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }



    /**
     * @Route("/api/rechercheavance/{gouvernorat}/{gouvernoratdest}/{adressedep}/{adressedest}/{date}/{type}", name="Recherche_avance")
     * @Method({"GET"})
     */
    public function RechercheAvanceAction($gouvernorat,$gouvernoratdest,$adressedep,$adressedest,$date,$type)

    {    $em = $this->getDoctrine()->getManager();

       if (($gouvernoratdest=="Hammamet") || ($gouvernoratdest=="Nebeul") || ($gouvernoratdest=="Zaghouan") || ($gouvernoratdest=="Sousse"))
       {
           $query = $em->createQuery(
               'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE  p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest AND p.datepublication=:date
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND  p.gouvernorat = :annonce AND  p.gouvernoratdest= :option2 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND  p.gouvernorat = :annonce AND p.gouvernoratdest= :option3 AND p.datepublication=:date  AND p.type=:type
            OR p.multiville=true AND p.gouvernorat = :annonce AND p.gouvernoratdest= :option4 AND p.datepublication=:date   AND p.type=:type
            OR  p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
           )->setParameter('annonce', $gouvernorat
           )->setParameter('adressedebut', '%'.$adressedep.'%')
               ->setParameter('adressedest','%'.$adressedest.'%')
               ->setParameter('annoncedest', $gouvernoratdest )
               ->setParameter('option1', "Sfax")
               ->setParameter('option2', "Sousse" )
               ->setParameter('option3', "Monastir")
               ->setParameter('option4', "Mahdia" )
               ->setParameter('date',$date)
               ->setParameter('type',$type)
           ;;
           $annonceavance = $query->getResult();

       }

        elseif (($gouvernoratdest=="Gabes") || ($gouvernoratdest=="Sfax"))
        {
            $query = $em->createQuery(
                'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest AND p.datepublication=:date
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND  p.gouvernorat = :annonce AND  p.gouvernoratdest= :option2 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
            )->setParameter('annonce', $gouvernorat
            )->setParameter('adressedebut', '%'.$adressedep.'%')
                ->setParameter('adressedest','%'.$adressedest.'%')
                ->setParameter('annoncedest', $gouvernoratdest )
                ->setParameter('option1', "Medenin")
                ->setParameter('option2', "Jersis" )
                ->setParameter('date',$date)
                ->setParameter('type',$type)
            ;;
            $annonceavance = $query->getResult();

        }

        elseif (($gouvernoratdest=="Jendouba") || ($gouvernoratdest=="Siliana") || ($gouvernoratdest=="Kef") ) {
            $query = $em->createQuery(
                'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest AND p.datepublication=:date
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option2 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
            )->setParameter('annonce', $gouvernorat
            )->setParameter('adressedebut', '%' . $adressedep . '%')
                ->setParameter('adressedest', '%' . $adressedest . '%')
                ->setParameter('annoncedest', $gouvernoratdest)
                ->setParameter('option1', "Kef")
                ->setParameter('date',$date)
                ->setParameter('type',$type)
                ->setParameter('option2', "Kasserine");;
            $annonceavance = $query->getResult();

        }

            elseif (($gouvernoratdest=="Sidi Bou zid") || ($gouvernoratdest=="Kasserine") || ($gouvernoratdest=="Gafsa") )
            {
                $query = $em->createQuery(
                    'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest 
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option2 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
                )->setParameter('annonce', $gouvernorat
                )->setParameter('adressedebut', '%'.$adressedep.'%')
                    ->setParameter('adressedest','%'.$adressedest.'%')
                    ->setParameter('annoncedest', $gouvernoratdest )
                    ->setParameter('option1', "Gafsa")
                    ->setParameter('date',$date)
                    ->setParameter('type',$type)
                    ->setParameter('option2', "Tozeur")

                ;;
                $annonceavance = $query->getResult();

            }

            elseif (($gouvernoratdest=="Tabarka"))
            {
                $query = $em->createQuery(
                    'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest 
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
                )->setParameter('annonce', $gouvernorat
                )->setParameter('adressedebut', '%'.$adressedep.'%')
                    ->setParameter('adressedest','%'.$adressedest.'%')
                    ->setParameter('annoncedest', $gouvernoratdest )
                    ->setParameter('date',$date)
                    ->setParameter('type',$type)
                    ->setParameter('option1', "Ain Drahem")

                ;;
                $annonceavance = $query->getResult();

            }

            elseif (($gouvernoratdest=="Kairouan"))
            {
                $query = $em->createQuery(
                    'SELECT   p 
            FROM CovoiturageBundle:AnnonceCo p
            WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest 
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option1 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.gouvernorat = :annonce AND  p.gouvernoratdest = :option2 AND p.datepublication=:date AND p.type=:type
            OR p.multiville=true AND p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
                )->setParameter('annonce', $gouvernorat
                )->setParameter('adressedebut', '%'.$adressedep.'%')
                    ->setParameter('adressedest','%'.$adressedest.'%')
                    ->setParameter('annoncedest', $gouvernoratdest )
                    ->setParameter('option1', "Sousse")
                    ->setParameter('option2', "Monastir")
                    ->setParameter('date',$date)
                    ->setParameter('type',$type)


                ;;
                $annonceavance = $query->getResult();

            }

            else
       {
           $query = $em->createQuery(
               'SELECT   p 
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernorat = :annonce AND p.gouvernoratdest = :annoncedest AND p.datepublication=:date AND p.type=:type OR  p.adressedebut LIKE :adressedebut OR p.adressedestination LIKE :adressedest'
           )->setParameter('annonce', $gouvernorat
           )->setParameter('adressedebut', '%'.$adressedep.'%')
               ->setParameter('adressedest', '%'.$adressedest.'%')
               ->setParameter('annoncedest', $gouvernoratdest )
               ->setParameter('date',$date)
               ->setParameter('type',$type)
           ;;
           $annonceavance = $query->getResult();

       }


        $data = $this->get('jms_serializer')->serialize($annonceavance, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }


}
