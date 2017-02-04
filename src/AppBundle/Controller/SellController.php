<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Offer;
use AppBundle\Form\Type\OfferType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SellController extends Controller
{
    /**
     * @Route("/wystaw/{hash}", name="sell")
     * @Template()
     */
    public function indexAction($hash = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if($hash)
        {
            $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
                'accessHash' => $hash
            ));
            if(!$offer) throw $this->createNotFoundException();
        }
        else
        {
            $offer = new Offer();
            if($user)
            {
                $offer->setEmail($user->getEmail());
                $offer->setFullname($user->getFullname());
                $offer->setCity($user->getCity());
                $offer->setPhone($user->getPhone());
            }
        }

        $form = $this->createForm(OfferType::class, $offer, array(
            'user' => $user
        ));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $addedPhotos = $request->request->get('photos');
            if($offer->getAccessHash())
            {
                $currentGallery = $offer->getGallery();
                $offer->setGallery(array_merge($currentGallery, (array)$addedPhotos));
            }
            else
            {
                $offer->setGallery((array)$addedPhotos);
                $offer->setAccessHash(md5(substr(uniqid().str_shuffle('abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789'), 0, rand(15,25))));
                $offer->setImage(isset($addedPhotos[0]) ? $addedPhotos[0] : null);
            }

            if(!$this->getUser())
            {
                //Sprawdźmy czy użytkownik o tym adresie e-mail isteniej w bazie

            }

            try {
                $em->persist($offer);
                $em->flush();
                return new RedirectResponse($this->generateUrl('sell_details', array(
                    'hash' => $offer->getAccessHash()
                )));
            }
            catch(\Exception $e)
            {
                $logger = $this->get('logger');
                $logger->error($e->getMessage());
                $this->addFlash('danger', 'Nie udało się dodać ogłoszenia. Pracujemy już nad rozwiązaniem tego problemu.');
            }
        }

        return [
            'form' => $form->createView(),
            'offer' => $offer->getAccessHash() ? $offer : null
        ];
    }

    /**
     * @Route("/wystaw/szczegoly/{hash}", name="sell_details")
     * @Template()
     */
    public function detailsAction($hash)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
            'accessHash' => $hash
        ));
        if(!$offer)
            throw $this->createNotFoundException();

        return [
            'offer' => $offer
        ];
    }

    /**
     * @Route("/wystaw/akceptacja/{hash}", name="sell_accept")
     * @Template()
     */
    public function endAction($hash, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
            'accessHash' => $hash
        ));
        if(!$offer)
            throw $this->createNotFoundException();

        $end = $request->request->get('end');
        if($end)
        {
            $promo = $request->request->get('promo');
            if($promo)
            {

            }

            $offer->setStatus(1);
            $em->persist($offer);
            $em->flush();
            return $this->render('@App/Sell/thanks.html.twig', array(
                'offer' => $offer
            ));
        }

        return [
            'offer' => $offer
        ];
    }

    /**
     * @Route("/changeMainPhoto/{hash}", name="sell_change_main_photo", condition="request.isXmlHttpRequest()")
     */
    public function changeMainPhotoAction($hash, Request $request)
    {
        $response = new JsonResponse();
        $img = $request->request->get('image');

        if(!file_exists('uploads/'.$img))
        {
            $response->setData(array(
                'success' => false,
                'msg' => 'Wybrany plik nie istnieje.'
            ));
            return $response;
        }

        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('AppBundle:Offer')->findOneBy(array(
            'accessHash' => $hash
        ));
        if(!$offer)
            throw $this->createNotFoundException();

        $offer->setImage($img);
        $em->persist($offer);
        $em->flush();

        $response->setData(array('success' => true));
        return $response;
    }
}
