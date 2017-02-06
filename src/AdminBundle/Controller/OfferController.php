<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/ogloszenia")
 */
class OfferController extends Controller
{
    /**
     * @Route("/edytuj/{id}", name="admin_offer_edit")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->find($id);
        if(!$offer)
            throw $this->createNotFoundException();

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $em->persist($offer);
                $em->flush();
                $this->addFlash('success', 'Ogłoszenie zostało poprawnie zmienione.');
                $this->redirectToRoute('admin_offer_edit', [
                    'id' => $id
                ]);
            } catch(\Exception $e)
            {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return [
            'offer' => $offer,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/edytuj/{id}/usunzdjecie", name="admin_offer_image_remove", condition="request.isXmlHttpRequest()")
     * @Method({"POST"})
     */
    public function removeImageAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();

        $offer = $em->getRepository('AppBundle:Offer')->find($id);
        if(!$offer)
        {
            $response->setData(['success' => false]);
            return $response;
        }

        $image = $request->request->get('img');
        $gallery = $offer->getGallery();

        if(($key = array_search($image, $gallery)) !== false)
        {
            unset($gallery[$key]);
            if(file_exists($this->getParameter('upload_dir').DIRECTORY_SEPARATOR.$image))
                unlink($this->getParameter('upload_dir').DIRECTORY_SEPARATOR.$image);
        }

        $offer->setGallery($gallery);
        $em->persist($offer);
        $em->flush();

        $response->setData(['success' => true]);
        return $response;
    }
}
