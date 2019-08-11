<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DomCrawler\Crawler;



class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


        /**
         * @Route("/", name="home")
         */
    //public function data()
    //{
    // require 'vendor/autoload.php';
    //Connection à la base de données
    // try{
    //    $pdo = new PDO('sqlite:bddBot.db');
    //    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    //  } catch(Exception $e) {
    //    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    //    die();
    //  }
    
    //Guzzle permet de récupérer le site web
//        $client = new \GuzzleHttp\Client();
//         $response = $client->request('GET', 'https://www.visorando.com/randonnee-sur-les-monts-de-bassens/');
//         $body = $response->getBody();

//     // Dom-crawler permet de filtrer les infos récupérées (image)
//     $crawler = new Crawler((string) $body);
    

//     $titles = $crawler->filterXPath('//h2[contains(@class, "ApidaeListingSimpleGrid-title")]')->extract(['_text']);
//     print_r($titles);
//     return $this->render('home/index.html.twig', [
//         'controller_name' => 'HomeController',
//     ]);
// }

}


