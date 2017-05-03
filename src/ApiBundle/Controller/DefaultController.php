<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventStatus;
use AppBundle\Entity\UserCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\ResultSetMapping;
use UserBundle\Entity\User;


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

        $user = $this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(array("email" => $email));

        $resultsArray["login"] = array();
        $array = array();
        $result = 200;

        if ($user === null) {
            $result = 401;
        }

        if ($result != 401) {
            $isValid = $this->get('security.password_encoder')->isPasswordValid($user, $password);

            if (!$isValid) {
                $result = 204;
                $array = array(
                    "result" => $result,
                    "email" => $user->getEmail(),
                );
            }
        }

        if ($result != 204) {
            $array = array(
                "result" => $result,
            );
        }

        array_push($resultsArray["login"], $array);
        return new Response(json_encode($resultsArray));


    }//nice

    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $email = $request->request->get("email");
        $password = $request->request->get("password");
        $name = $request->request->get("name");
        $surname = $request->request->get("surname");
        $phone = $request->request->get("phone");
        $photo = $request->request->get("photo");
        $jobTitle = $request->request->get("jobTitle");
        $webSite = $request->request->get("webSite");
        $gender = $request->request->get("gender");
        $age = $request->request->get("age");
        $username=$request->request->get("username");

        $resultsArray["register"] = array();
        $result = 200;

        $user = new User();
        $user->setFirstName($name)
            ->setSurName($surname)
            ->setEmail($email)
            ->setEmailCanonical($email)
            ->setAge($age)
            ->setGender($gender)
            ->setPhone($phone)
            ->setJobTitle($jobTitle)
            ->setWebSite($webSite)
            ->setPhoto($photo)
            ->setPlainPassword($password)
            ->setUsername($username)
            ->setEnabled(1);
        $em->persist($user);
        $em->flush();

        if ($user === null) {
            $result = 401;
        }

        $array = array(
            "result" => $result,
        );

        array_push($resultsArray["register"], $array);
        return new Response(json_encode($resultsArray));

    }//nice

    public function userAction(Request $request)
    {
        $email = $request->request->get("email");
        $user = $this->getDoctrine()->getRepository("UserBundle:User")->findOneBy(array("email" => $email));

        $resultsArray["user"] = array();
        $result = 200;

        if ($user === null) {
            $result = 401;
        }

        if ($result == 200) {
            $array = array(
                "result" => $result,
                "email" => $email,
                "firstName" => $user->getFirstName(),
                "surName" => $user->getSurName(),
                "phone" => $user->getPhone(),
                "photo" => $user->getPhoto(),
                "jobTitle" => $user->getJobTitle(),
                "webSite" => $user->getWebSite(),
                "gender" => $user->getGender(),
                "age" => $user->getAge()
            );
        } else {
            $array = array(
                "result" => $result,
            );
        }

        array_push($resultsArray["user"], $array);
        return new Response(json_encode($resultsArray));


    }//nice

    public function mainPageEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cityid=$request->request->get("cityid");
        $userid=$request->request->get("userid");



        $user = $this->getDoctrine()->getRepository("UserBundle:User")->find($userid);
        $city = $this->getDoctrine()->getRepository("AppBundle:City")->find($cityid);
        $resultsArray["mainPageEvent"] = array();
        $eventArray = array();

        $result = 200;


        if (null === $user or null === $city) {
            $result = 401;
            $array = array(
                "result" => $result,
            );
        } else {

            if ($user->getUserCategory() != null) {

                $category_ids = array();
                foreach ($user->getUserCategory() as $userCategory) {
                    $category_ids[] = "e.category='" . $userCategory->getCategory()->getId() . "'";
                }

                $query = $em->createQuery("SELECT e FROM AppBundle:Event e
        WHERE (" . implode('  OR ', $category_ids) . ") and e.city='" . $city->getId() . "'");

                $events = $query->getResult();


                foreach ($events as $event) {
                    array_push($eventArray, $event->getId());

                }
                $array = array(
                    "result" => $result,
                    "Eventsid" => $eventArray
                );
            } else {
                $result = 401;
                $array = array(
                    "result" => $result,
                );
            }

        }


        array_push($resultsArray["mainPageEvent"], $array);
        return new Response(json_encode($resultsArray));


    }//nice

    public function createEventAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $title = $request->request->get("title");
        $address = $request->request->get("address");
        $startDate = $request->request->get("startDate");
        $endDate = $request->request->get("endDate");
        $eventDescription = $request->request->get("eventDescription");
        $orgName = $request->request->get("orgName");
        $orgDiscription = $request->request->get("orgDiscription");
        $type = $request->request->get("type");
        $topic = $request->request->get("topic");
        $capacity = $request->request->get("capacity");
        $userid = $request->request->get("userid");
        $cityid = $request->request->get("cityid");
        $categoryid = $request->request->get("categoryid");
        $image= $request->request->get("image");

        $user = $this->getDoctrine()->getRepository("UserBundle:User")->find($userid);
        $city = $this->getDoctrine()->getRepository("AppBundle:City")->find($cityid);
        $category = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid);

        $firstDate = new \DateTime($startDate);
        $secondDate = new \DateTime($endDate);
        $resultsArray["createEvent"] = array();
        $result = 200;


        $event = new Event();
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
            ->setImage($image)
            ->setUser($user)
            ->setCity($city)
            ->setCategory($category);

        $em->persist($event);
        $em->flush();

        if ($event === null) {

            $result = 401;
            $array = array(
                "result" => $result,
            );
        } else {
            $array = array(
                "result" => $result,
            );
        }


        array_push($resultsArray["createEvent"], $array);
        return new Response(json_encode($resultsArray));


    }//nice

    public function cityAction(Request $request)
    {
        $cities = $this->getDoctrine()->getRepository("AppBundle:City")->findAll();


        $resultsArray["cities"] = Array();
        $result = 200;
        foreach ($cities as $city) {
            $cityInfo[] = array("cityid" => $city->getId(),
                "cityName" => $city->getName(),
            );
        }

        $array = array(
            "result" => $result,
            "city"=>$cityInfo,
        );

        return new Response(json_encode($array));
    }//nice

    public function categoryAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository("AppBundle:Category")->findAll();


        $resultsArray["categories"] = Array();
        $result = 200;
        foreach ($categories as $category) {
            $categoryInfo[] = array("categoryid" => $category->getId(),
                "categoryName" => $category->getCategoryName(),
            );

        }

        $array = array(
            "result" => $result,
            "city"  =>  $categoryInfo,
        );
        return new Response(json_encode($array));

    }//nice

    public function eventInfoAction(Request $request)
    {
        $eventid = $request->request->get("eventid");
        $event = $this->getDoctrine()->getRepository("AppBundle:Event")->find($eventid);
        $resultsArray["eventInfo"] = array();
        $result = 200;

        if ($event === null) {
            $result = 401;
            $array = array(
                "result" => $result,
            );
        } else {
            $array = array(
                "result" => $result,
                "address" => $event->getAddress(),
                "capacity" => $event->getCapacity(),
                "category" => $event->getCategory()->getCategoryName(),
                "city" => $event->getCity()->getName(),
                "endDate" => $event->getEndDate(),
                "startDate" => $event->getStartDate(),
                "eventDescription" => $event->getEventDescription(),
                "image" => $event->getImage(),
                "orgDiscrp" => $event->getOrgDiscription(),
                "orgName" => $event->getOrgName(),
                "title" => $event->getTitle(),
                "topic" => $event->getTopic(),
                "type" => $event->getType(),
                "userid" => $event->getUser()->getId(),
            );
        }

        array_push($resultsArray["eventInfo"], $array);
        return new Response(json_encode($resultsArray));
    }//nice

    public function goToEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userid = $request->request->get("userid");
        $eventid = $request->request->get("eventid");
        $status = $request->request->get("status");
        $resultsArray["goToEvent"] = array();
        $result = 401;

        $user = $this->getDoctrine()->getRepository("UserBundle:User")->find($userid);
        $event = $this->getDoctrine()->getRepository("AppBundle:Event")->find($eventid);
        $eventStatus = $this->getDoctrine()->getRepository("AppBundle:EventStatus")->findOneBy(array("user" => $user, "event" => $event));

        if ($eventStatus === null) {
            $result = 200;
            $evntStt = new EventStatus();
            $evntStt->setUser($user);
            $evntStt->setEvent($event);
            $evntStt->setStatus($status);

            $em->persist($evntStt);
            $em->flush();

        } else {
            $result = 200;
            $eventStatus->setStatus($status);
            $em->persist($eventStatus);
            $em->flush();
        }

        $array = array(
            "result" => $result,
        );

        array_push($resultsArray["goToEvent"], $array);
        return new Response(json_encode($resultsArray));
    }//nice

    public function categoryPickAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryid1 = $request->request->get("categoryid1");
        $categoryid2 = $request->request->get("categoryid2");
        $categoryid3 = $request->request->get("categoryid3");
        $categoryid4 = $request->request->get("categoryid4");
        $categoryid5 = $request->request->get("categoryid5");
        $userid = $request->request->get("userid");
        $resultsArray["categoryPick"] = array();
        $result = 200;

        $category1 = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid1);
        $category2 = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid2);
        $category3 = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid3);
        $category4 = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid4);
        $category5 = $this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid5);
        $user = $this->getDoctrine()->getRepository("UserBundle:User")->find($userid);

        $categorynew1 = new UserCategory();
        $categorynew1->setUser($user);
        $categorynew1->setCategory($category1);
        $em->persist($categorynew1);

        $categorynew2 = new UserCategory();
        $categorynew2->setUser($user);
        $categorynew2->setCategory($category2);
        $em->persist($categorynew2);

        $categorynew3 = new UserCategory();
        $categorynew3->setUser($user);
        $categorynew3->setCategory($category3);
        $em->persist($categorynew3);

        $categorynew4 = new UserCategory();
        $categorynew4->setUser($user);
        $categorynew4->setCategory($category4);
        $em->persist($categorynew4);

        $categorynew5 = new UserCategory();
        $categorynew5->setUser($user);
        $categorynew5->setCategory($category5);
        $em->persist($categorynew5);

        $em->flush();


        $array = array(
            "result" => $result,
        );

        array_push($resultsArray["categoryPick"], $array);
        return new Response(json_encode($resultsArray));

    }//nice

    public function thisWeekAction(Request $request)
    {
        $events = $this->getDoctrine()->getRepository('AppBundle:Event')->findAll();
        $resultsArray["thisWeek"] = array();
        $newEvents = array();

        $result = 200;
        foreach ($events as $event) {
           // $now = new \DateTime($event->getStartDate());
            $created = new \DateTime('now');
            $diff = date_diff($event->getStartDate(), $created);

            $days = $diff->format('%d');
            $month  = $diff->format('%m');
            $years = $diff->format('%y');


            if ($days < 8 and $month == 0 and $years == 0) {
                $result=201;
               $newEvents[]=$event->getId();
            }

        }


        $array = array(
            "result" => $result,
            "Events"=>$newEvents,
        );
        array_push($resultsArray["thisWeek"],$array);

        return new Response(json_encode($resultsArray));





    }//nice

    public function statusEventAction(Request $request)
    {
        $userid = $request->request->get('userid');
        $eventid=$request->request->get('eventid');
        $result = 200;
        $resultsArray["statusEvent"] = array();


        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($userid);
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($eventid);

        $eventStatus = $this->getDoctrine()->getRepository('AppBundle:EventStatus')->findOneBy(array('user' => $user,'event'=>$event));



        if ($eventStatus === null) {
            $result = 401;

        } else {
            $result = 200;
        }

        $array = array(
            "result" => $result,
            "eventStatus"=> $eventStatus->getStatus(),
        );

        array_push($resultsArray["statusEvent"], $array);
        return new Response(json_encode($resultsArray));

    }//nice

    public function searchAction(Request $request)
    {
        $cityid=$request->request->get('cityid');
        $categoryid=$request->request->get('categoryid');
        $date1=$request->request->get('date1');
        $date2=$request->request->get('date2');

        $firstDate = new \DateTime($date1);
        $secondDate = new \DateTime($date2);


        $resultsArray["search"] = array();
        $newEvents = array();

        $result = 200;

        $city=$this->getDoctrine()->getRepository("AppBundle:City")->find($cityid);
        $category=$this->getDoctrine()->getRepository("AppBundle:Category")->find($categoryid);

        $events=$this->getDoctrine()->getRepository("AppBundle:Event")->findBy(array('city'=>$city,'category'=>$category));

        $date1str = strtotime($firstDate->format('d-m-Y'));
        $date2str = strtotime($secondDate->format('d-m-Y'));



        foreach($events as $event)
        {
            $eventDate = strtotime($event->getStartDate()->format('d-m-Y'));

            if($eventDate > $date1str and $eventDate < $date2str)
            {
                $result=201;
                $newEvents[]=$event->getId();
            }

        }



        $array = array(
            "result" => $result,
            "Events"=>$newEvents,
        );
        array_push($resultsArray["search"],$array);

        return new Response(json_encode($resultsArray));



    }
}
