<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementsController extends Controller
{
    /**
     * @Route("/moje/ogloszenia/", name="user_announcements")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ads = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o')
            ->where('o.email = :email')
            ->andWhere('o.endDate IS NULL')
            ->setParameter(':email', $this->getUser()->getEmail())
            ->getQuery()
            ->getResult();

        return [
            'ads' => $ads
        ];
    }

    /**
     * @Route("/moje/ogloszenia/zakonczone", name="user_announcements_ended")
     */
    public function endedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ads = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o')
            ->where('o.email = :email')
            ->andWhere('o.endDate IS NOT NULL')
            ->setParameter(':email', $this->getUser()->getEmail())
            ->getQuery()
            ->getResult();

        return $this->render('@User/Announcements/index.html.twig', array(
            'ads' => $ads
        ));
    }
}
