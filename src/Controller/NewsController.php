<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//CONTROLLER PARA EXEMPLIFICAR UMA REQUISIÇÃO, NÃO É UTILIZADA
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
    #[Route('/news/new')]
    public function new(EntityManagerInterface $entityManager): Response {

        $news = new News();
        $rand = rand(18, 30);
        $news->setTitle('Jovem de '.$rand.' idade recebe um premio');
        $news->setDescription('Um jovem brasileiro de '.$rand.' de idade, recebe um premio não sei por que e não sei pra que');

        $entityManager->persist($news);
        $entityManager->flush($news);
        return new Response('<h1>Noticia criada </h1> em '.$news->getCreateAt()->format('d/m/Y h:i:s'));
    }
}