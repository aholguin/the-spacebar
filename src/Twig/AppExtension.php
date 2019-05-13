<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    /**
     * @var MarkdownHelper
     */
    private $markdownHelper;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'],['is_safe' => ['html']]),
        ];
    }


    public function processMarkdown($value)
    {
        return $this->container
            ->get('foo')
            ->parse($value);
    }

    public static function getSubscribedServices()
    {
        return [
            'foo' => MarkdownHelper::class,
        ];

    }
}
