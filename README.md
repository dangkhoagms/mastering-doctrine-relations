# NOTE
### Work AppFixtures Relation ManyToOne


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
### Remname Class Fixtures
 
You can implement DependentFixtureInterface of lib use Doctrine\Common\DataFixtures\DependentFixtureInterface;

    public function getDependencies()
        {
            return [
                ArticleFixtures::class
            ];
        }
