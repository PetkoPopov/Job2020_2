<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Plan;
use JobBundle\Entity\Role;
use JobBundle\Entity\User;
use JobBundle\Form\UserType;
use JobBundle\Repository\PlanRepository;
use JobBundle\Service\Encryption\EncryptionService;
use JobBundle\Service\Encryption\EncryptionServiceInterface;
use JobBundle\Service\UserSecvice\UserServiceIterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;

class UserController extends Controller
{
    /**
     * @var EncryptionServiceInterface
     */
    private $encryption;
    /**
     * @var UserServiceIterface
     */
    private $service;
    public function __construct(EncryptionService $encryption,UserServiceIterface $service)
    {
        $this->service=$service;
        $this->encryption=$encryption;
    }

    /**
     * @param EncryptionServiceInterface $encryption
     */
    public function setEncryption(EncryptionServiceInterface $encryption): void
    {
        $this->encryption = $encryption;
    }

    /**
     * @return EncryptionServiceInterface
     */
    public function getEncryption(): EncryptionServiceInterface
    {
        return $this->encryption;
    }

    /**
     * @Route("/new",name="user_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     */
    public function new(Request $request){
        $user= new User();
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
//            $hashPassword=$this->encryption->hashPassword($user->getPassword());
//            $user->setPassword($hashPassword);
            $hashPassword=$this->get('security.password_encoder')
                ->encodePassword($user,$user->getPassword());
            $user->setPassword($hashPassword);
            $roleUser=
                $this->getDoctrine()->getRepository(Role::class)
                ->findOneBy(['status'=>'ROLE_USER']);
            $user->addRole($roleUser);

//             $em=$this->getDoctrine()
//                ->getManager();
//            $em->persist($user);
//            $em->flush();
            $this->service->create($user);
            return $this->redirectToRoute('security_login');
        }
        return $this->render('user/new.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("user/{id}",name="user_profile")
     *
     * @param $id
     */
public  function oneUser(int $id){
//$user=
//    $this->getDoctrine()
//    ->getRepository(User::class)
//    ->findOneBy(['id'=>$id]);
$user=$this->service->findOneById($id);

return $this->render("user/profile.html.twig",['user'=>$user]);
}

    /**
     * @Route("jobToDo/{id}",name="job_todo")
     * @param $id
     * @return Response
     */
public function jobToDo(int $id){
//$user= new User();
    $user=$this->service->findOneById($id);
/////////////////////////////
///        работещ код да не забравя да напиша ...,Repository,Test в service.yml
//    $user=
//        $this
//        ->getDoctrine()
//        ->getRepository(User::class)
//        ->findOneBy(["id"=>$id]);
////////////////////////////////////
//echo"<pre>";
//var_dump($user->getPlans());
//echo "</pre>";
//die;
    $userPlans=$user->getPlans();
     return $this->render('user/plans.html.twig',['user'=>$user]);
}


    /**
     * @Route("/all", name="user_all")
     */
    public function all(){
//        $all=$this->getDoctrine()
//            ->getRepository(User::class)
//            ->findAll();
        $all=$this->service->findall();
        return $this->render("user/all.html.twig",['all'=>$all]);
    }


    /**
     * @Route("/myIntern/{id}",name="user_intern")
     * @param integer $id
     * @return Response
     */
       public  function internTillNow(int $id){
//           $user =new User();
//       $user=$this->getDoctrine()->getRepository(User::class)
//           ->findOneBy(['id'=>$id]);4
           $user=$this->service->findOneById($id);
        return $this->render('user/intern.html.twig',['user'=>$user]);
       }



}
