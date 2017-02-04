<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\UserInvoiceData;
use UserBundle\Form\ChangePassType;
use UserBundle\Form\InvoiceDataType;
use UserBundle\Form\SettingsType;

/**
 * @Route("/ustawienia")
 */
class SettingsController extends Controller
{
    /**
     * @Route("/", name="settings")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(SettingsType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Dane zostały poprawnie zmienione.');
            return $this->redirectToRoute('settings');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/faktura", name="settings_invoice")
     * @Template()
     */
    public function invoiceAction(Request $request)
    {
        $user = $this->getUser();
        $invoiceData = $user->getInvoiceData();
        if(!$invoiceData)
            $invoiceData = new UserInvoiceData();

        $form = $this->createForm(InvoiceDataType::class, $invoiceData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoiceData);
            $user->setInvoiceData($invoiceData);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Dane do faktury zostały poprawnie zmienione.');
            return $this->redirectToRoute('settings_invoice');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/haslo", name="settings_pass")
     * @Template()
     */
    public function changePassAction(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePassType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword()));
            $em->persist($user);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Zmiana hasła w serwisie '.$this->getParameter('nazwa'))
                ->setFrom($this->getParameter('noreply_email'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('@User/Settings/changePassEmail.html.twig', array(
                        'user' => $user
                    )),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $this->addFlash('success', 'Hasło zostało poprawnie zmienione.');
            return $this->redirectToRoute('settings_pass');
        }

        return [
            'form' => $form->createView()
        ];
    }
}
