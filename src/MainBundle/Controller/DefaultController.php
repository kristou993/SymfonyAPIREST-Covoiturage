<?php

namespace MainBundle\Controller;
use MainBundle\Entity\Annonce;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MainBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        $article = new Annonce();
        $article
            ->setTitre('Mon premier article')
            ->setDescription('Le contenu de mon article.')
        ;
        $data = $this->get('jms_serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


}
