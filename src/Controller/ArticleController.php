<?php
/**
 * Created by PhpStorm.
 * User: Anderson Holguin
 * Date: 2/25/2019
 * Time: 4:09 PM
 */

namespace App\Controller;


//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render("article/homepage.html.twig");
    }

    /**
     * @Route("/news/{slug}", name="app_show")
     */
    public function show($slug, MarkdownParserInterface $markdown, AdapterInterface $cache)
    {

        $array = array("10","20","30");
        $articleContent = <<<EDO
Lorem *ipsum* **dolor** "sit" $array[0] 'amet', consectetur adipiscing elit. [Fusce ut ante quam](https://www.coachacademico.com). Vestibulum metus diam, accumsan eu leo ut, aliquam accumsan felis. Proin efficitur, risus vel sagittis finibus, 
*metus diam ullamcorper ante*, a vestibulum ante augue at purus. Aliquam blandit leo non dui sodales, et malesuada purus rutrum. Nam feugiat metus a nulla sodales accumsan. Etiam pretium, 
sem vel accumsan ultricies, mauris ipsum ultricies lacus, a tristique odio justo accumsan erat. Suspendisse justo nunc, efficitur in nibh in, fringilla finibus augue. Suspendisse potenti. 
Etiam congue, augue ac condimentum mollis, ex urna malesuada lacus, a ultricies mi dui nec arcu. Aenean pulvinar nisl arcu, at aliquet nunc commodo in. Sed vitae nunc congue, ornare augue 
sit amet, lobortis sapien. Quisque posuere ultricies convallis.

**Curabitur risus** libero, posuere quis nisl ac, pharetra mattis lacus. Duis ultricies neque lacus, et commodo metus porta a. Sed tempus feugiat maximus. Etiam condimentum ornare leo non malesuada. 
In quis tincidunt justo, ac pellentesque sapien. Sed ultricies dolor eget dolor egestas scelerisque. Nulla vitae iaculis lectus. Vivamus vitae sem eu ipsum iaculis finibus sed sed odio. Phasellus 
non faucibus odio. Nam dignissim tristique nisi. Donec convallis egestas mauris, id tincidunt mi mollis ut.

Vestibulum dignissim nulla in cursus accumsan. Etiam sit amet fermentum mauris. Nunc sed mauris tincidunt, suscipit turpis sit amet, consectetur quam. Aenean viverra dolor vel vehicula tincidunt. 
Integer dapibus molestie augue ac maximus. Fusce ut pulvinar enim, nec fermentum tortor. Phasellus vitae lectus velit. Nunc ac elementum quam, et ornare nunc. In porttitor facilisis neque, nec consectetur 
massa pharetra sed. Donec a justo tristique, tempus est et,ultricies urna. Morbi aliquam a arcu commodo scelerisque. Aenean non fermentum tortor.
EDO;

        $item = $cache->getItem('aaaa_'.md5($articleContent));
         if(!$item->isHit()){
             $item->set($markdown->transform($articleContent));
             $cache->save($item);
         }
        $articleContent = $item->get();
        //dump($item); die();

        //$articleContent = $markdown->transform($articleContent);
        $comments = ["Texto 1", "Texto 2", "Texto 3"];
        return $this->render("article/show.html.twig", [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'articleContent' =>$articleContent,
            'slug' => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart",name="article_toggle_heart")
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //return new Response(json_encode(['hearts'=>5]));
        $logger->info("Article has been hearted");
        return new JsonResponse(["hearts" => rand(5, 100)]);
    }
}