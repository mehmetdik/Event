<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    public function homepageAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }

    public function cityEventsAction()
    {
        return $this->render('AppBundle::cityEvents.html.twig');
    }

    public function mainRegisterAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $name=$request->request->get('name');
        $surname=$request->request->get('surname');
        $email=$request->request->get('email');
        $password=$request->request->get('password');
        $username=$request->request->get('nickname');

        $resultsArray["register"] = array();
        $result = 200;

        $user = new User();
        $user->setFirstName($name)
            ->setSurName($surname)
            ->setEmail($email)
            ->setEmailCanonical($email)
            ->setAge('')
            ->setGender('')
            ->setPhone('')
            ->setJobTitle('')
            ->setWebSite('')
            ->setPhoto('')
            ->setPlainPassword($password)
            ->setUsername($username)
            ->setEnabled(1);
        $em->persist($user);
        $em->flush();



       return new Response(json_encode($resultsArray));
    }
}
