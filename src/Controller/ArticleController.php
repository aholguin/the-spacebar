<?php
/**
 * Created by PhpStorm.
 * User: Anderson Holguin
 * Date: 2/25/2019
 * Time: 4:09 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function  homepage(){
        return new Response("Working");
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show ($slug){
        return new Response(sprintf("Variable por URL; %s", $slug));
    }
}