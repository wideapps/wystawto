<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Category;
use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter(':status', 2)
            ->setMaxResults(10)
            ->orderBy('o.id', 'DESC')
            ->getQuery()->getResult();

        $categories = $em->getRepository('AppBundle:Category')->findBy([
            'parent' => null
        ]);

        return [
            'offers' => $offers,
            'categories' => $categories
        ];
    }

    /**
     * @Route("/ajax/newest", name="homepage_ajax_newest", condition="request.isXmlHttpRequest()")
     * @Template()
     */
    public function loadNewestAction(Request $request)
    {
        $city = $request->get('city');
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o');

        $offers = $qb
            ->where('o.status = :status')
            ->setParameter(':status', 2)
            ->setMaxResults(10)
            ->orderBy('o.id', 'DESC');

        if($city != 'Polska')
        {
            $offers->andWhere($qb->expr()->like('o.city', ':city'))
                ->setParameter(':city', '%'.$city.'%');
        }

        return [
            'offers' => $offers->getQuery()->getResult()
        ];
    }

}
