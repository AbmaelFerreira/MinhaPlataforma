<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsService
{
//        private $httpClient;   // Apartir do PHP8 não preciso mais dessa informação, somente adicionar private no atributo do construtor
        public function  __construct(
            private HttpClientInterface $httpClient,
            private CacheInterface $cacheInterface){
//          $this->httpClient = $httpClient; // Apartir do PHP8 não preciso mais dessa informação, somente adicionar private no atributo do construtor
        }


    public function getCategoryList(){
        $categories = $this->cacheInterface->get('news_categories', function (CacheItemInterface $cacheItem){

            $cacheItem->expiresAfter(10);
            $url  = 'https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayCategoryNews.json';

            $html = $this->httpClient->request('GET', $url);

            $news =  $html->toArray();

            return $news;
        });

        return $categories;
    }

    public function getNewsList(){
        $newsList = $this->cacheInterface->get('news_list', function (CacheItemInterface $cacheItem){

            $cacheItem->expiresAfter(10);

            $url  = 'https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayNews.json';

            $html = $this->httpClient->request('GET', $url);

            $news =  $html->toArray();

            return $news;
        })  ;
        return $newsList;

    }
}