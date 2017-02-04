<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

/**
 * @Route("/zaloz-konto")
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/", name="register")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $confirmToken = md5(uniqid().substr(str_shuffle('abcdefghijklmnoprstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ1234567890'), 0, rand(15,20)));
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword()));
            $user->setConfirmToken($confirmToken);

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Rejestracja w serwisie '.$this->getParameter('nazwa'))
                    ->setFrom($this->getParameter('noreply_email'))
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView('@User/Registration/confirmAccount.html.twig', array(
                            'user' => $user
                        )),
                        'text/html'
                    );
                $this->get('mailer')->send($message);

                return $this->redirectToRoute('register_success');
            } catch(\Exception $e)
            {
                $log = $this->get('logger');
                $log->error($e->getMessage());
                $this->addFlash('error', 'Przepraszamy, nie udało się założyć nowego konta. Pracujemy już nad rozwiązaniem tego problemu.');
            }

        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/aktywuj/{hash}", name="register_activate")
     * @Template()
     */
    public function activateAction($hash)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('UserBundle:User')->findOneBy(array(
            'confirmToken' => $hash
        ));
        if(!$user)
            throw $this->createNotFoundException();

        $user->setIsActive(true);
        $user->setConfirmToken(null);
        $em->persist($user);
        $em->flush();

        return [];
    }

    /**
     * @Route("/sukces", name="register_success")
     * @Template()
     */
    public function completeAction()
    {
        return [];
    }
}
