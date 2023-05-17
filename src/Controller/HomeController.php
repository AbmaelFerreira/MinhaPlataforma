<?php

namespace App\Controller;

use App\Entity\News;
use App\Service\NewsService;
use App\service\StringManipulationService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;
use function Symfony\Component\String\u;

class HomeController extends  AbstractController {

    public function __construct( #[Autowire('kernel.debug')] private bool $isDebug ) { }

    #[Route('/', name: 'app_home')]
    public function home(
            LoggerInterface $logger,
            HttpClientInterface $httpclient,
            StringManipulationService $stringManipulationService,
            Environment $twig,
            HttpClientInterface $httpClient,
            NewsService $service
    ):Response{

        $test = 'abmael]de[lima]ferreira]Fera';

        $novaString = $stringManipulationService->cleanString($test);

        $response =$httpclient->request('GET','https://127.0.0.1:8000/api/news/12');

        $logger->warning('Acessou a home');

        $logger->error('Array criada');

        $pageTitle =  "Sistama de Notícias";

        $logger->info('Titulo definido');

        return $this->render('hello/homepage.html.twig',[

             'pageTitle' => $pageTitle,
             'categories' => $service->getCategoryList($httpClient),
            ]);
    }

    #[Route('/categoria/{slug}', name: 'app_category')]
    public function category( $slug,EntityManagerInterface $entityManager ):Response{

        $newsRepository = $entityManager->getRepository(News::class);
        $news = $newsRepository->findAll();
        $pageTitle =  $slug;

        return $this->render('hello/category.html.twig', [

            'pageTitle' => $pageTitle,
            'news'=> $news
       ]);
    }
}