<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * @Route("/post/new", name="new_post")
     */
    public function newPost(Request $request)
    {
        $user1 = New User();
        $entityManager=$this->getDoctrine()->getManager();
        //crea nuevo objeto Post
        $post = new Post();
        //crear formulario
        $form = $this->createForm(PostType::class,$post);
        //handle the request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //data capture
            $post=$form->getData();
            //flush hacia base de datos

            $entityManager->persist($post);
            $entityManager->flush();

        }
        //render the form
        return $this->render('post/post.html.twig', [
            'form' => $form->createView()]);
    }
    
}
