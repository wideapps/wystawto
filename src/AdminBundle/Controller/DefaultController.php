<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter(':status', 1)
            ->setMaxResults(6)
            ->getQuery()->getResult();

        return $this->render('AdminBundle:Default:index.html.twig', [
            'offers' => $offers
        ]);
    }
}
