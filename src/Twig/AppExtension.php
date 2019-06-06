<?php

namespace App\Twig;

use App\services\MarkDownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

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
            new TwigFilter('cached_markdown', [$this, 'processMarkup'],['is_safe'=>['html']]),
        ];
    }

    public function processMarkup($value)
    {

        return $this->container
            ->get(MarkDownHelper::class)
            ->parse($value);
    }

    public static function getSubscribedServices()
    {

        return[
            MarkDownHelper::class
        ];

    }

}
