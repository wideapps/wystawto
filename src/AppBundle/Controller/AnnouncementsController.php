<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementsController extends Controller
{

    /**
     * @Route("/ogloszenie/{id}-{slug}", name="announcement", requirements={
     *  "id": "\d+"
     * })
     * @Template()
     */
    public function seeAction($id, $slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->find($id);
        if(!$offer || $this->get('slugify')->slugify($offer->getTitle()) != $slug)
            throw $this->createNotFoundException();

        if(!$request->cookies->get('announcement_'.$id))
        {
            $response = new Response();
            $response->headers->setCookie(new Cookie('announcement_'.$id, 1, time()+60*60));
            $response->sendHeaders();

            $offer->setViews($offer->getViews() + 1);
            $em->persist($offer);
            $em->flush();
        }

        return [
            'offer' => $offer
        ];
    }

    /**
     * @Route("/odswiez/{hash}", name="announcements_refresh")
     * @Template()
     */
    public function refreshAction($hash)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
            'accessHash' => $hash
        ));
        if(!$offer) throw $this->createNotFoundException();

        return [
            'offer' => $offer
        ];
    }

    /**
     * @Route("/promuj/{hash}", name="announcements_promote")
     * @Template()
     */
    public function promoteAction($hash)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
            'accessHash' => $hash
        ));
        if(!$offer) throw $this->createNotFoundException();

        return [
            'offer' => $offer
        ];
    }

    /**
     * @Route("/zakoncz", name="announcements_end", condition="request.isXmlHttpRequest()")
     * @Method("POST")
     */
    public function endAction(Request $request)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id', 0);
        $sold = $request->request->get('sold');

        $offer = $em->getRepository('AppBundle:Offer')->findOneBy([
            'id' => $id,
            'email' => $this->getUser()->getEmail()
        ]);
        if(!$offer)
        {
            $response->setData(['success' => false]);
            return $response;
        }

        $offer->setSold($sold);
        $offer->setEndDate(new \DateTime('now'));

        $em->persist($offer);
        $em->flush();

        $response->setData(['success' => true]);
        return $response;
    }

}
