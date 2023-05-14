<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController {
    #[Route('api/news/{id}', name: 'api_new', methods: ['GET'])]
    public function  getNew(int $id=null): Response {

        // TODO - criar uma query real
        $new = [
            "id" => $id,
            "titulo" => "Artista brasileiro é premiado em festival",
            "categoria" => "Cultura",
            "descricao" => "O artista brasileiro João da Silva ganhou o premio de melhor filme no festival",
            "data" => "https://exemplo.com/imagem/arte.jpg"

        ];
        return new JsonResponse($new);
    }

}