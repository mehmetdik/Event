<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    public function loginAction(Request $request)
    {
        $email = $request->request->get("email");
        $password = $request->request->get("password");

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(array("email"=>$email));

        $resultsArray["login"]=array();
        $array=array();
        $result=200;

        if ($user === null) {  $result=401;  }

        if($result!=401)
        {
            $isValid = $this->get('security.password_encoder')->isPasswordValid($user, $password);

            if (!$isValid) {
                $result=204;
                $array=array(
                    "result"=>$result,
                    "email"=>$user->getEmail(),
                );
            }
        }

        if($result!=204)
        {
            $array=array(
                "result"=>$result,
            );
        }

        array_push($resultsArray["login"], $array);
        return new Response( json_encode($resultsArray));


    }

    public function userAction(Request $request)
    {
        $email=$request->request->get("email");
        $user=$this->getDoctrine()->getRepository("UserBundle:User")->findOneBy(array("email"=>$email));

        $resultsArray["user"]=array();
        $result=200;

        if ($user === null) {  $result=401;  }

        if($result==200)
        {
            $array=array(
                "result"=>$result,
                "email"=>$email,
                "firstName"=>$user->getFirstName(),
                "surName"=>$user->getSurName(),
                "phone"=>$user->getPhone(),
                "photo"=>$user->getPhoto(),
                "jobTitle"=>$user->getJobTitle(),
                "webSite"=>$user->getWebSite(),
                "gender"=>$user->getGender(),
                "age"=>$user->getAge()
            );
        }else{
            $array=array(
                "result"=>$result,
            );
        }

        array_push($resultsArray["user"], $array);
        return new Response( json_encode($resultsArray));



    }

}
