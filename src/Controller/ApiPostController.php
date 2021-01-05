<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em ,ValidatorInterface $validator)
    {
        $json = $request->getContent();

        try{
        $post = $serializer->deserialize($json,Post::class,'json');

        $post->setCreatedAt(new \DateTime());

        $errors = $validator->validate($post);

        if(count($errors) > 0) {
            return $this->json($errors,400);
        }

        $em->persist($post);
        $em->flush();

        return $this->json($post,201,[],["groups" => "post:read"]);
        }
        catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ],400);
        }

    }
}
