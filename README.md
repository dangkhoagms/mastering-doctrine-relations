# NOTE
### Twig extension
##### src/Twig/AppExtension.php

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
##### show.html.twig
    {{ article_content  | cached_markdown}}
    
    
# SCRIPT
### make entity
    bin/console make:entity

### create database
    bin/console doctrine:database:create
### make:migration
    bin/console make:migration
### create table to database
    bin/console make:migrations:migrate
### fixture data 
    bin/console make:fixtures
### doctrine load data
    bin/console doctrine:fixtures:load
### Twig extensions!
    bin/console make:twig-extension