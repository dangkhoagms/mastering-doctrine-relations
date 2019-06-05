<?php

namespace App\Twig;

use App\services\MarkDownHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var MarkDownHelper
     */
    private $helper;

    public function __construct(MarkDownHelper $helper)
    {
        $this->helper = $helper;
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
        return $this->helper->parse($value);
    }
}
