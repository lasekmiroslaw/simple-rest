<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Api\Serializer;
use App\Api\FormProcesor;

class PostController extends Controller
{
    /**
     * @Route("/api/posts")
     * @Method("POST")
     */
    public function new(Request $request, FormProcesor $formProcessor, Serializer $serializer)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $formProcessor->processForm($form, $request);

        if ($form->isSubmitted() && !$form->isValid()) {
            return $formProcessor->createValidationErrorResponse($form);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUserId($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return new JsonResponse($serializer->serialize($post), 201, [], true);
        }
    }
    /**
     * @Route("/api/posts")
     * @Method("GET")
     */
    public function list(Serializer $serializer)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        return new JsonResponse($serializer->serialize(['postst' => $posts]), 200, [], true);
    }
}
