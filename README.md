# NOTE
### 1. Work AppFixtures Relation ManyToOne


**add data**
Using 
    
    $this->addReference($className . '_' . $i, $entity);

**Get data**

    $this->getReference(Article::class . '_'.$this->faker->numberBetween(0,10))
**Code**

    namespace App\DataFixtures;
    
    use App\Entity\Article;
    use App\Entity\Comment;
    use Doctrine\Common\Persistence\ObjectManager;
    
    class CommentFixtures extends AppFixtures
    {
    
        protected function loadData(ObjectManager $manager)
        {
            $this->createMany(Comment::class, 100, function (Comment $comment) {
                $article = $this->getReference(Article::class . '_'.$this->faker->numberBetween(0,10));
                $comment->setContent(
                    $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
                );
                $comment->setAuthorName($this->faker->name);
                $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
                $comment->setArticle($article);
          });
            $manager->flush();
    
        }
    
    }


**class CommentFixtures**

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $article = $this->getReference(Article::class . '_'.$this->faker->numberBetween(0,10));
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            );
            $comment->setAuthorName($this->faker->name);
            $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $comment->setArticle($article);
      });
        $manager->flush();

    }
### 2. Rename Class Fixtures
 
You can implement DependentFixtureInterface of lib use Doctrine\Common\DataFixtures\DependentFixtureInterface;

    public function getDependencies()
        {
            return [
                ArticleFixtures::class
            ];
        }
### 3. criteria with comment delete
***class ArticleRepository***

    public function createNonDeletedCriteria(){
            return $criteria = Criteria::create()
                ->andWhere(Criteria::expr()->eq('isDeleted',false))
                ->orderBy(['createdAt'=>'DESC']);
        }
***class Article***
    
    public  function getNoneDeleteComments():Collection
        {
    
            return $this->comments->matching(ArticleRepository::createNonDeletedCriteria());
        }
        
### 4. Working Twig

Run script twig

Run script debug:twig to view syntax

    {{ comment.content | truncate}}
    
    
### 5. Query database using like param

      public function findAllWithSearch($term){

        $qb = $this->createQueryBuilder('c');

        if($term){
            $qb->andWhere('c.content LIKE :term OR c.authorName LIKE :term')
            ->setParameter('term','%'.$term.'%');
        }
        return $qb->getQuery()->getResult();

      }

### 6. Work paginator

***commentController***
    
    public function index(CommentRepository $commentRepository,Request $request,PaginatorInterface $paginator)
        {
            $q = $request->query->get('p');
            $QueryBuilder = $commentRepository->getWithSearchQueryBuilder($q);
            $pagination = $paginator->paginate(
                $QueryBuilder, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                10 /*limit per page*/
            );
            return $this->render('comment_admin/index.html.twig', [
                'controller_name' => 'CommentAdminController',
                'pagination'=>$pagination,
                'query'=>$q
            ]);
        }
        
***Repository***
    
     public function getWithSearchQueryBuilder($term):QueryBuilder
        {
    
            $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.article','a');
    
            if($term){
                $qb->andWhere('c.content LIKE :term OR c.authorName LIKE :term OR a.name LIKE :term')
                ->setParameter('term','%'.$term.'%');
            }
            return $qb->orderBy("c.id",'DESC');
    
        }


***view***
    
    <div class="navigation">
                {{ knp_pagination_render(pagination) }}
            </div>
***Configuration config/packages/knp_paginator.yaml***

    knp_paginator:
      template:
        pagination: '@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig'

    
***document*** 
https://github.com/KnpLabs/KnpPaginatorBundle
    
### Working DependentFixtureInterface
implement DependentFixtureInterface and

        public function getDependencies()
        {
            return [
                TagFixtures::class,
            ];
        }


# SCRIPT

### 1. twig extension
    composer require twig/extensions
### 2. install lib paginator
    composer require knplabs/knp-paginator-bundle
 
