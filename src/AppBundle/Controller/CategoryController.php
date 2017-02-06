<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Category;
use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/kategoria")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/{id}-{slug}", name="category")
     * @Template()
     */
    public function indexAction($id, $slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Category')->find($id);
        if(!$category || $this->get('slugify')->slugify($category->getTitle()) != $slug)
            throw $this->createNotFoundException();

        $offers = $em->getRepository('AppBundle:Offer')->createQueryBuilder('o')
            ->where('o.status = :status')
            ->andWhere('o.category = :category')
            ->setParameter(':status', 2)
            ->setParameter(':category', $category)
            ->orderBy('o.id', 'DESC')
            ->getQuery()->getResult();

        return [
            'offers' => $offers,
            'category' => $category
        ];
    }

}
