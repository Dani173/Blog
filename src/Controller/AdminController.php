<?php

namespace App\Controller;
use App\Form\AdminUserType;
use App\Form\FormAdminType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 *
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig',[
            'users'=>$users]);
    }
    /**
     * @Route("/admin/create", name="app_create")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $user->setIsActive(true);
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
        $error = $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            //encriptacion plainpassowrd
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success', 'User created'
            );
            return $this->redirectToRoute('app_admin');
        }
        //renderizar el formulario
        return $this->render('admin/crear.html.twig.html', [
            'error' => $error,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/{id}", name="app_show")
     */
    public function pruebaID($id){
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('admin/show.html.twig', array('user'=> $user));
    }

    /**
     * @Route("/admin/edit/{id}", name="app_edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
        $error = $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            //encriptacion plainpassowrd
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $hola="hola";
            $users=$this->getDoctrine()->getRepository(User::class)->findAll();
            return $this->render('admin/index.html.twig',[
                'users'=>$users, 'hola'=>$hola]);
        }
        //renderizar el formulario
        return $this->render('admin/edit.html.twig', [
            'error' => $error,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id){
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig',[
            'users'=>$users]);
    }

}
