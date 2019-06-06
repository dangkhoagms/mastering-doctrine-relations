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
install lib using script 8
 
**Template html**

    {{ article.publishedAt | ago }}
**Read more at** https://github.com/KnpLabs/KnpTimeBundle

### 3. Working with ServiceSubscribeInterface
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
**template html**

    {{ article_content |cached_markdown}}

### 4. Custom query 

        public function findByExampleField()
        {
            return $this->createQueryBuilder('a')
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
**Read more:**
(https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/dql-doctrine-query-language.html)

### 4. Working Ajax
**src/Controller/ArticleController.php** 
add method return count heart
    
     /**
         * @Route("/heart/{id}", name="article_heart", methods={"GET","POST"})
         */
        public function heart_count(Article $article){
            $article->setHeartCount($article->getHeartCount()+1);
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse(['heart'=>$article->getHeartCount()]);
    
        }
    
**public/js/work_heart.js**
    
    $(document).ready(function (e) {
        $('.heart').click(function (event) {
            $.ajax({
                url:'/article/heart/'+$('#article-id').text(),
                method:'POST'
            }).done(function (data) {
                $('.heart').html(data['heart']);
            });
        });
    
    });
**templates/base.html.twig**

    {% block js %}
                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
                <script src="{{ asset('js/work_heart.js') }}" ></script>
    % endblock %}
**template/article/show.html.twig**
edit table

     <table class="table">
            <tbody>
                <tr>
                    <th>Id</th>
                    <td id="article-id">{{ article.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ article.name }}</td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>{{ article.content }}</td>
                </tr>
                <tr>
                    <th>Tym</th>
                    <td class="heart">{{ article.heartCount }}</td>
                </tr>
            </tbody>
        </table>
### 5. Working faker 
`install script 10` 

**change class AppFixtures**
    
    class AppFixtures extends Fixture
    {
        /** @var Generator */
        protected $faker;
    
        public function __construct()
        {
            $this->faker = Factory::create();
        }
    
        public function load(ObjectManager $manager)
        {
            // $product = new Product();
            // $manager->persist($product);
    
            $manager->flush();
        }
    }

**change class ArticleFixtures**
    
    class ArticleFixtures extends AppFixtures
    {
        private static $Article_titles = [
            'foo one',
            'foo two'
        ];
        private static $Article_heart = [0,10,20,100];
    
        public function load(ObjectManager $manager)
        {
            for ($i = 1; $i <= 10; $i++) {
                $article = new Article();
                $article->setName($this->faker->randomElement(self::$Article_titles));
                $article->setContent(sprintf("baz%d", $i));
                $article->setPublishedAt(new \DateTime());
                $article->setHeartCount($this->faker->randomElement(self::$Article_heart));
                $manager->persist($article);
            }
    
            $manager->flush();
        }
    }
and then `run script 6`

**Read more**
https://github.com/fzaninotto/Faker#fakerprovideren_uscompany
# SCRIPT
### 1. Make entity
    bin/console make:entity
### 2. Create database
    bin/console doctrine:database:create
### 3. Make:migration
    bin/console make:migration
### 4. Create table to database
    bin/console doctrine:migrations:migrate
### 5. fixture data 
    bin/console make:fixtures
### 6. Doctrine load data
    bin/console doctrine:fixtures:load
### 7. Twig extensions!
    bin/console make:twig-extension
### 8. Query Sql with doctrine
    bin/console doctrine:query:sql "select * from table_name"
### 9. Install lib Kpn Time Bundle
    composer require knplabs/knp-time-bundle
### 10. Install lib faker
    composer require fzaninotto/faker
  
