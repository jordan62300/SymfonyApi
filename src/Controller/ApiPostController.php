<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
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
}
