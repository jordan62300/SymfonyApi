<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository)
    {

      //  $posts = $postRepository->findAll();

    //    $json = $serializer->serialize($posts,'json',['groups' => 'post:read']);

     //   $response = new JsonResponse($json,200,[],true);

      return   $this->json($postRepository->findAll(),200,[],["groups" => 'post:read']);
    }

    /**
     * @Route("/api/post", name="api_post_create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $json = $request->getContent();

        $post = $serializer->deserialize($json,Post::class,'json');

        $post->setCreatedAt(new \DateTime());

        $em->persist($post);
        $em->flush();

        return $this->json($post,201,[],["groups" => "post:read"]);


    }
}
