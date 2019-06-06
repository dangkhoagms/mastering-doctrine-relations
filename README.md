# NOTE
### 1. Twig extension
**src/Twig/AppExtension.php** 

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

**template show.html.twig**

    {{ article_content  | cached_markdown}}

### 2. using lib Kpn Time Bundle
install lib using script 7
 
**Template html**

    {{ article.publishedAt | ago }}
**Read more at** https://github.com/KnpLabs/KnpTimeBundle
 

# SCRIPT
### 1. Make entity
    bin/console make:entity
### 2. Create database
    bin/console doctrine:database:create
### 3. Make:migration
    bin/console make:migration
### 4. Create table to database
    bin/console doctrine:migrations:migrate
### fixture data 
    bin/console make:fixtures
### 5. Doctrine load data
    bin/console doctrine:fixtures:load
### 6. Twig extensions!
    bin/console make:twig-extension
### 7. Query Sql with doctrine
    bin/console doctrine:query:sql "select * from table_name"
### 7. Install lib Kpn Time Bundle
    composer require knplabs/knp-time-bundle

