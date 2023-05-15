<?php

namespace App\Controller;

use App\service\StringManipulationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;
use function Symfony\Component\String\u;

class HomeController extends  AbstractController {

    #[Route('/', name: 'app_home')]
    public function home(
            LoggerInterface $logger,
            HttpClientInterface $httpclient,
            StringManipulationService $stringManipulationService,
            Environment $twig,
            HttpClientInterface $httpClient
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
                  'categories' => $this->getCategoryList($httpClient),
//                   'categories' => $categories,
                  ]);

    }

    #[Route('/categoria/{slug}', name: 'app_category')]
    public function category(string $slug=null, HttpClientInterface $httpClient):Response{


        $pageTitle =  $slug;


        return $this->render('hello/category.html.twig', [

            'categories' => $this->getCategoryList($httpClient),
            'pageTitle' => $pageTitle,
            'news' => $this->getNewsList($httpClient)
       ]);
    }


    #[Route('/reportagens')]
    public function getTest(Request $request): Response {

        $nome = "";
        $sobrenome = "";

          if($request->get('nome')){
              $nome =  $request->get('nome');
          }


         if($request->get('sobrenome')){
             $sobrenome =  $request->get('sobrenome');
         }

        $categories = [
            ['title'=> 'Mundo',         'text' => 'Noticias sobre  mundo'],
            ['title'=> 'Brasil',        'text' => 'Noticias sobre  Brasil'],
            ['title'=> 'Tecnologia',    'text' => 'Noticias sobre  tecnologia'],
            ['title'=> 'Design',        'text' => 'Noticias sobre  Design'],
            ['title'=> 'Cultura',       'text' => 'Noticias sobre  Cultura'],
            ['title'=> 'Negócios',      'text' => 'Noticias sobre  Negocios'],
            ['title'=> 'Política',      'text' => 'Noticias sobre  Politica'],
            ['title'=> 'Opinião',       'text' => 'Noticias sobre  Opinião'],
            ['title'=> 'Ciência',       'text' => 'Noticias sobre  Ciencia'],
            ['title'=> 'Saúde',         'text' => 'Noticias sobre  Saúde'],
            ['title'=> 'Estilo',        'text' => 'Noticias sobre  Estilo'],
            ['title'=> 'Viagens',       'text' => 'Noticias sobre  Viagens'],
        ];

        dump($nome);
        dump($sobrenome);

        return $this->render('reportagens.html.twig', [
            'categories' => $categories,
//            'nome' => $nome,
//            'sobrenome' => $sobrenome
        ]);
    }



    public function getCategoryList($httpClient){

        $url  = 'https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayCategoryNews.json';

        $html = $httpClient->request('GET', $url);

        $news =  $html->toArray();

        return $news;
    }

    public function getNewsList($httpClient){

        $url  = 'https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayNews.json';

        $html = $httpClient->request('GET', $url);

        $news =  $html->toArray();

        return $news;
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