<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Api\Serializer;
use App\Api\FormProcesor;

class CommentController extends Controller
{
    /**
     * @Route("/api/posts/{id}/comments")
     * @Method("POST")
     */
    public function newComment(int $id, Request $request, FormProcesor $formProcessor, Serializer $serializer)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        if (!$post) {
            throw $this->createNotFoundException(sprintf(
                'No posts found for id "%s"',
                $id
              ));
        }
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $formProcessor->processForm($form, $request);

        if ($form->isSubmitted() && !$form->isValid()) {
            return $formProcessor->createValidationErrorResponse($form);
        }

        $comment->setUser($this->getUser());
        $comment->setPost($post);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return new JsonResponse($serializer->serialize($comment), 201, [], true);
    }
}
