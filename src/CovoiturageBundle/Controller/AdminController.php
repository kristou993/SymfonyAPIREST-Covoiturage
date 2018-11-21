<?php

namespace CovoiturageBundle\Controller;

use CovoiturageBundle\Entity\AnnonceCovoiturage;
use CovoiturageBundle\Entity\AnnonceCo;
use CovoiturageBundle\Entity\Reclamation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;


class AdminController extends Controller
{
    /**
     * @Route("/admin",name="adminHome")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('AnnonceAdmin');

    }

    /**
     * @Route("/adminAnnonce",name="AnnonceAdmin")
     */
    public function AnnonceAdminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $m=$em->getRepository(AnnonceCo::class)->FindAll();

        return $this->render('@Covoiturage/Admin/gestionAnnonce.html.twig',array("annonces"=>$m));
    }

    /**
     * @Route("/adminReclamation",name="adminReclamation")
     */
    public function ReclamationAdminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $m=$em->getRepository(Reclamation::class)->FindAll();

        return $this->render('@Covoiturage/Admin/gestionReclamation.html.twig',array("reclamations"=>$m));
    }

    /**
     * @Route("/adminReclamationDelete/{id}",name="DeleteReclamation")
     */
    public function EffacerReclamationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation=$em->getRepository("CovoiturageBundle:Reclamation")->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('adminReclamation');

    }
    /**
     * @Route("/adminAnnonceDelete/{id}",name="DeleteAnnonce")
     */
    public function EffacerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce=$em->getRepository("CovoiturageBundle:AnnonceCo")->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('AnnonceAdmin');

    }

    /**
    * @Route("/statGouvernorat",name="statGouvernorat")
    */

    public function StatGouvernoratAction()
    {

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Annonce par Destination');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'animation'=>true,
            'selected'=>true,
            'dataLabels' => array(
                'enabled' => true,
                'format' => '{point.name}: {point.y:.1f}'),
            'showInLegend'  => true

        ));


        $data=array();
        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT   count(p.gouvernorat) as AA
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernoratdest = :annonce'
        )->setParameter('annonce', 'Tunis'
        );;
        $count2 = $query->getResult();
        foreach ($count2 as $values)
        {
            $tunis=array('Tunis',intval($values['AA']));
            array_push($data,$tunis);
        }


        $query1 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as sousse
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernoratdest = :sousse'
        )->setParameter('sousse', 'Sousse'
        );;
        $count3 = $query1->getResult();

        foreach ($count3 as $values)
        {
            $sousse=array('sousse',intval($values['sousse']));
            array_push($data,$sousse);
        }


        $query2 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as Sfax
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernoratdest = :sfax'
        )->setParameter('sfax', 'Sfax'
        );;

        $count4 = $query2->getResult();


        foreach ($count4 as $values)
        {
            $Sfax=array('Sfax',intval($values['Sfax']));
            array_push($data,$Sfax);
        }



        $query3 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as Nabeul
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.gouvernoratdest = :nabeul'
        )->setParameter('nabeul', 'Nebeul'
        );;

        $count5 = $query3->getResult();


        foreach ($count5 as $values)
        {
            $nabeul=array('Nabeul',intval($values['Nabeul']));
            array_push($data,$nabeul);
        }


        $ob->series(array(array('type' => 'pie','name' => 'Annonces', 'data' => $data)));
        return $this->render('CovoiturageBundle:Admin:PieChart.html.twig', array(
            'chart' => $ob));
    }

    /**
     * @Route("/TypeAnnoncestat",name="TypeAnnonce")
     */

    public function TypeAnnonceAction()
    {

        $ob = new Highchart();
        $ob->chart->renderTo('linechart1');
        $ob->title->text('Annonce par Type');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'animation'=>true,
            'selected'=>true,
            'dataLabels' => array(
                'enabled' => true,
                'format' => '{point.name}: {point.y:.1f}'),
            'showInLegend'  => true

        ));


        $data=array();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT   count(p.type) as AA
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.type = :annonce'
        )->setParameter('annonce', 'Demande'
        );;
        $count2 = $query->getResult();
        foreach ($count2 as $values)
        {
            $demande=array('Demande',intval($values['AA']));
            array_push($data,$demande);
        }


        $query1 = $em->createQuery(
            'SELECT   count(p.type) as offre
    FROM CovoiturageBundle:AnnonceCo p
    WHERE p.type = :offre'
        )->setParameter('offre', 'Offre'
        );;
        $count3 = $query1->getResult();

        foreach ($count3 as $values)
        {
            $offre=array('Offre',intval($values['offre']));
            array_push($data,$offre);
        }



        $ob->series(array(array('type' => 'pie','name' => 'Annonces', 'data' => $data)));
        return $this->render('@Covoiturage/Admin/PieChartTypeAnnonce.html.twig', array(
            'chart' => $ob));
    }
    /**
     * @Route("/Dashboard",name="Dashboard")
     */
    public function DashBordAction()
    {

        return $this->render('CovoiturageBundle:Admin:Dashboard.html.twig'
        );
    }

    /**
     * @Route("/RecGouvernorat",name="RecGouvernorat")
     */

    public function ReclGouvernoratAction()
    {

        $ob = new Highchart();
        $ob->chart->renderTo('linechart3');
        $ob->title->text('Reclamation par Gouvernorat');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'animation'=>true,
            'selected'=>true,
            'dataLabels' => array(
                'enabled' => true,
                'format' => '{point.name}: {point.y:.1f}'),
            'showInLegend'  => true

        ));


        $data=array();
        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT   count(p.gouvernorat) as AA
    FROM CovoiturageBundle:Reclamation p
    WHERE p.gouvernorat = :tunis'
        )->setParameter('tunis', 'Tunis'
        );;
        $count2 = $query->getResult();
        foreach ($count2 as $values)
        {
            $tunis=array('Tunis',intval($values['AA']));
            array_push($data,$tunis);
        }


        $query1 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as sousse
    FROM CovoiturageBundle:Reclamation p
    WHERE p.gouvernorat = :sousse'
        )->setParameter('sousse', 'Sousse'
        );;
        $count3 = $query1->getResult();

        foreach ($count3 as $values)
        {
            $sousse=array('sousse',intval($values['sousse']));
            array_push($data,$sousse);
        }


        $query2 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as Sfax
    FROM CovoiturageBundle:Reclamation p
    WHERE p.gouvernorat = :sfax'
        )->setParameter('sfax', 'Sfax'
        );;

        $count4 = $query2->getResult();


        foreach ($count4 as $values)
        {
            $Sfax=array('Sfax',intval($values['Sfax']));
            array_push($data,$Sfax);
        }



        $query3 = $em->createQuery(
            'SELECT   count(p.gouvernorat) as Nabeul
    FROM CovoiturageBundle:Reclamation p
    WHERE p.gouvernorat = :nabeul'
        )->setParameter('nabeul', 'Nabeul'
        );;

        $count5 = $query3->getResult();


        foreach ($count5 as $values)
        {
            $nabeul=array('Nabeul',intval($values['Nabeul']));
            array_push($data,$nabeul);
        }


        $ob->series(array(array('type' => 'pie','name' => 'Reclamations', 'data' => $data)));
        return $this->render('CovoiturageBundle:Admin:RecPieChart.html.twig', array(
            'chart' => $ob));
    }



}
