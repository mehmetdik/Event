<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;




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

    public function mainPageEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cityid=$request->request->get("cityid");
        $userid=$request->request->get("userid");


        $user=$this->getDoctrine()->getRepository("UserBundle:User")->find($userid);
        $city=$this->getDoctrine()->getRepository("AppBundle:City")->find($cityid);
        $resultsArray["mainPageEvent"]=array();
        $eventArray=array();

        $result=200;


        if(null === $user or null === $city)
        {
            $result=401;
            $array=array(
                "result"=>$result,
            );
        }else{


            if($user->getUserCategory() != null)
            {

                $category_ids=array();
                foreach ($user->getUserCategory() as $userCategory) {
                    $category_ids[]="e.category='".$userCategory->getCategory()->getId()."'";
                }

                $query = $em->createQuery("SELECT e FROM AppBundle:Event e
        WHERE (" . implode('  OR ', $category_ids) . ") and e.city='".$city->getId()."'");

                $events= $query->getResult();






                foreach ($events as $event)
                {
                    array_push($eventArray,$event->getId());

                }
                $array=array(
                    "result"=>$result,
                    "Eventsid"=>$eventArray
                );
            }else{
                $result=401;
                $array=array(
                    "result"=>$result,
                );
            }

        }




        array_push($resultsArray["mainPageEvent"], $array);
        return new Response( json_encode($resultsArray));


    }

    public function createEventAction(Request $request)
    {
        $title=$request->request->get("title");
        $address=$request->request->get("address");
        $startDate=$request->request->get("startDate");
        $endDate=$request->request->get("endDate");
        $eventDescription=$request->request->get("eventDescription");
        $orgName=$request->request->get("orgName");
        $orgDiscription=$request->request->get("orgDiscription");
        $type=$request->request->get("type");
        $topic=$request->request->get("topic");
        $capacity=$request->request->get("capacity");
        $userid=$request->request->get("userid");
        $cityid=$request->request->get("cityid");
        $categoryid=$request->request->get("categoryid");

        $user=$this->getDoctrine()->getRepository("UserBundle:User")->find($userid);
        $city=$this->getDoctrine()->getRepository("UserBundle:User")->find($cityid);
        $category=$this->getDoctrine()->getRepository("UserBundle:User")->find($categoryid);

        $firstDate=new \DateTime($startDate);
        $secondDate=new \DateTime($endDate);
        $resultsArray["createEvent"]=array();
        $result=200;


            $event=new Event();
            $event->setTitle($title)
                ->setAddress($address)
                ->setStartDate($firstDate)
                ->setEndDate($secondDate)
                ->setEventDescription($eventDescription)
                ->setOrgName($orgName)
                ->setOrgDiscription($orgDiscription)
                ->setType($type)
                ->setTopic($topic)
                ->setCapacity($capacity)
                ->setUser($user)
                ->setCity($city)
                ->setCategory($category);


            if($event === null){

                $result=401;
                $array=array(
                    "result"=>$result,
                );
            }else{
                $array=array(
                    "result"=>$result,
                );
            }



        array_push($resultsArray["createEvent"], $array);
        return new Response( json_encode($resultsArray));


    }

    public function cityAction(Request $request)
    {
        $cities=$this->getDoctrine()->getRepository("AppBundle:City")->findAll();


        $resultsArray["cities"] = Array();
        $result=200;
        foreach($cities as $city)
        {
            $cityInfo[]=array("cityid"=>$city->getId(),
                "cityName"=>$city->getName(),
            );
            array_push($resultsArray["cities"],$cityInfo);

        }

        $array=array(
            "result"=>$result,
        );
        array_push($result["result"],$array);
        return new Response( json_encode($resultsArray));
    }

    public function categoryAction(Request $request)
    {
        $categories=$this->getDoctrine()->getRepository("AppBundle:Category")->findAll();


        $resultsArray["categories"] = Array();
        $result=200;
        foreach($categories as $category)
        {
            $categoryInfo[]=array("categoryid"=>$category->getId(),
                "categoryName"=>$category->getCategoryName(),
            );
            array_push($resultsArray["categories"],$categoryInfo);

        }

        $array=array(
            "result"=>$result,
        );
        array_push($result["result"],$array);
        return new Response( json_encode($resultsArray));

    }

    public function eventInfoAction(Request $request)
    {
        $eventid=$request->request->get("eventid");
        $event=$this->getDoctrine()->getRepository("AppBundle:Event")->find($eventid);
        $resultsArray["eventInfo"]=array();
        $result=200;

        if($event === null){
            $result=401;
            $array=array(
                "result"=>$result,
            );
        }else{
            $array=array(
                "result"=>$result,
                "address"=>$event->getAddress(),
                "capacity"=>$event->getCapacity(),
                "category"=>$event->getCategory()->getCategoryName(),
                "city"=>$event->getCity()->getName(),
                "endDate"=>$event->getEndDate(),
                "startDate"=>$event->getStartDate(),
                "eventDescription"=>$event->getEventDescription(),
                "image"=>$event->getImage(),
                "orgDiscrp"=>$event->getOrgDiscription(),
                "orgName"=>$event->getOrgName(),
                "title"=>$event->getTitle(),
                "topic"=>$event->getTopic(),
                "type"=>$event->getType(),
                "userid"=>$event->getUser()->getId(),
                );
        }

        array_push($resultsArray["eventInfo"], $array);
        return new Response( json_encode($resultsArray));
    }


}
