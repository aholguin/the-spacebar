<?php
/**
 * Created by PhpStorm.
 * User: Anderson Holguin
 * Date: 2/25/2019
 * Time: 4:09 PM
 */

namespace App\Controller;


//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function  homepage(){
       return $this->render("article/homepage.html.twig");
    }

    /**
     * @Route("/news/{slug}", name="app_show")
     */
    public function show ($slug){
        $comments = ["Texto 1", "Texto 2", "Texto 3"];
        return $this->render("article/show.html.twig",[
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart",name="article_toggle_heart")
     */
    public function toggleArticleHeart($slug){
        //return new Response(json_encode(['hearts'=>5]));
        return new JsonResponse(["hearts"=>rand(5,100)]);
    }
}