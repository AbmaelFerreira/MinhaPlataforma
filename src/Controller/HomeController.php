<?php

namespace App\Controller;

use App\Service\NewsService;
use App\service\StringManipulationService;
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


    public function __construct(
        #[Autowire('kernel.debug')]
            private bool $isDebug
    )
    {
    }

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

//                $html = $twig->render('hello/homepage.html.twig', [
//
//                    'pageTitle' => $pageTitle,
//                    'categories' => $categories,
//                ]);


               // return new Response($html);
              return $this->render('hello/homepage.html.twig',[

                   'pageTitle' => $pageTitle,
                  'categories' => $service->getCategoryList($httpClient),
//                   'categories' => $categories,
                  ]);

    }

    #[Route('/categoria/{slug}', name: 'app_category')]
    public function category(
                                string $slug=null,
                                HttpClientInterface $httpClient,
                                NewsService $service):Response{


        $pageTitle =  $slug;


        return $this->render('hello/category.html.twig', [

            'categories' => $service->getCategoryList($httpClient),
            'pageTitle' => $pageTitle,
            'news' => $service->getNewsList($httpClient)
       ]);
    }


    #[Route('/reportagens')]
    public function getTest(
                            Request $request,
                            HttpClientInterface $httpClient,
                            NewsService $service): Response {

                $nome = "";
                $sobrenome = "";

                if($request->get('nome')){
                    $nome =  $request->get('nome');
                }
                if($request->get('sobrenome')){
                    $sobrenome =  $request->get('sobrenome');
                }
                dump($nome);
                dump($sobrenome);

            return $this->render('reportagens.html.twig', [
            'categories' => $service->getCategoryList($httpClient),
            //'nome' => $nome,
            //'sobrenome' => $sobrenome
        ]);
    }




//    #[Route('/news/{id}')]
//    public function newsDetail(int $id=null, HttpClientInterface $httpclient){
//            $response =$httpclient->request('GET','https://127.0.0.1:8000/api/news/'.$id);
//            dd($response->toArray());
//            exit;
//    }

//        #[Route('/animal/{slug}')]
//        public function animal(string $slug=null):Response{
//
//            $newSlug = str_replace('-', ' ',$slug);
//            $newSlug = u($newSlug)->title(true);
//            return new Response('Olá : '.$newSlug);
//        }
}