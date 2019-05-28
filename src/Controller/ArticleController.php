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
    public function show(Article $article, SlackClient $slack )
    {

        if ($article->getSlug() === 'khaaaaaan'){
            $slack->sendMessage("AHA","message from service!!");
        }

        $comments = ["Texto 1", "Texto 2", "Texto 3"];
        return $this->render("article/show.html.twig", [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart",name="article_toggle_heart")
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        //return new Response(json_encode(['hearts'=>5]));
        $logger->info("Article has been hearted");
        $article->incrementHeartCount();
        $em->flush();
        return new JsonResponse(["hearts" => $article->getHeartCount()]);
    }
}