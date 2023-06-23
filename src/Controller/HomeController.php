<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\NewsCategory;
use App\Repository\NewsCategoryRepository;
use App\Repository\NewsRepository;
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

    /**
     * @param bool $isDebug
     * @param NewsService $newsService
     */
    public function __construct(
        #[Autowire('kernel.debug')]
        private bool $isDebug,
        private NewsService $newsService
    ) { }

    #[Route('/', name: 'app_home')]
    public function home(
            LoggerInterface $logger,
            HttpClientInterface $httpclient,
            StringManipulationService $stringManipulationService,
            Environment $twig,
            HttpClientInterface $httpClient,
            NewsCategoryRepository $newsCategoryRepository
    ): Response {

        $test = 'abmael]de[lima]ferreira]Fera';

        $novaString = $stringManipulationService->cleanString($test);

        //$response =$httpclient->request('GET','http://127.0.0.1/api/news/12');

        $logger->warning('Acessou a home');

        $logger->error('Array criada');

        $pageTitle =  "Sistama de Notícias";

        $logger->info('Titulo definido');
        $categery = $newsCategoryRepository->findAllCategoryOrderByTitle();

        return $this->render('hello/homepage.html.twig',[

             'pageTitle' => $pageTitle,
             'categories' => $categery
            ]);
    }
    #[Route('/categoria/{slug}', name: 'app_category')]
    public function category($slug, NewsCategoryRepository $newsCategoryRepository): Response
    {
        $news = $this->newsService->findByCategoryTitle($slug);
        $pageTitle =  $slug;
        $categories = $newsCategoryRepository->findBy([],['title'=>'ASC']);

        return $this->render('hello/category.html.twig', [
            'pageTitle' => $pageTitle,
            'news'=> $news,
            'categories'=> $categories
       ]);
    }
    #[Route(path: '/pesquisa/', name: 'app_news_filter')]
    public function filter(Request $request, NewsRepository $newsRepository): Response
    {
      $search = $request->query->get('search');
      $listNews = $newsRepository->findBySearch($request->query->get('search')); //refatorar para o servico

      return $this->render('search.html.twig', [
        'news' => $listNews,
        'search' => $search
      ]);
    }

    #[Route(path: '/news/{slug}', name: 'app_news_detail')]
    public function newsDetail(News $news=null): Response
    {
        if (!$news) {
            throw $this->createNotFoundException('Noticia não encontrada');
        }

//        if ($news->getCreateAt() < \DateTimeImmutable::createFromFormat('j-M-Y', '23-JUN-2023' )) {
//          throw $this->createNotFoundException('Notícia muito antiga');
//        }

        return $this->render('newsDetail.html.twig', [
            'news' => $news
        ]);
    }
}