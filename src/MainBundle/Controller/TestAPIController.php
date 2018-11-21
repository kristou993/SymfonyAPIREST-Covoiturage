<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MainBundle\Entity\Annonce;
use Symfony\Component\HttpFoundation\Response;
class TestAPIController extends Controller
{
    /**
     * @Route("/annonces", name="article_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $annonce = $this->get('jms_serializer')->deserialize($data, 'MainBundle\Entity\Annonce', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/annonces", name="article_create")
     */
    public function testAnotAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }
}
