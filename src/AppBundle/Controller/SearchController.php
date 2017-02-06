<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Offer;
use AppBundle\Form\Type\OfferType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/szukaj", name="search")
     * @Method({"POST"})
     */
    public function indexAction(Request $request)
    {
        if(!$request->request->get('search'))
            throw $this->createNotFoundException();

        $q = $request->request->get('q');
        $locale = $request->request->get('localization');
        if($locale)
        {
            $inc = explode(',', $locale);
            $locale = $inc[0];
        }
        else {$locale = 'Polska';}

        return $this->redirectToRoute('search_results', array(
            'locale' => $locale,
            'q' => $q
        ));
    }

    /**
     * @Route("/ogloszenia/{locale}", name="search_results")
     * @Template()
     */
    public function resultsAction()
    {
        
    }

}
