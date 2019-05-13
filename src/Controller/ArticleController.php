<?php
/**
 * Created by PhpStorm.
 * User: Anderson Holguin
 * Date: 2/25/2019
 * Time: 4:09 PM
 */

namespace App\Controller;


//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(bool $isDebug )
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();
        return $this->render("article/homepage.html.twig",['articles'=>$articles]);
    }

    /**
     * @Route("/news/{slug}", name="app_show")
     */
    public function show($slug, MarkdownHelper $markdownHelper, SlackClient $slack, EntityManagerInterface $em )
    {

        if ($slug === 'khaaaaaan'){
            $slack->sendMessage("AHA","message from service!!");
        }

        $repository= $em->getRepository(Article::class);

        /** @var Article $article */
        $article = $repository->findOneBy(['slug'=>$slug]);

        if (!$article){
        throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        $array = array("10","20","30");


        //dump($item); die();
        //$articleContent = $markdown->transform($articleContent);
        $comments = ["Texto 1", "Texto 2", "Texto 3"];
        return $this->render("article/show.html.twig", [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'article' => $article,
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