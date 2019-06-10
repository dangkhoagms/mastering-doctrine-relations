<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends AppFixtures implements DependentFixtureInterface
{
    private static $Article_titles = [
        'foo one',
        'foo two'
    ];
    private static $Article_heart = [0, 10, 20, 100];


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setName($this->faker->name);
            $article->setContent(sprintf($this->faker->paragraph));
            $article->setPublishedAt(new \DateTime());
            $article->setHeartCount($this->faker->randomElement(self::$Article_heart));
            $article->setSlug($this->faker->slug);
            $tags = $this->getRandomReferences(Tag::class,$this->faker->numberBetween(0,5));
            foreach ($tags as $tag){
                dd($tag);
                $article->addTag($tag);

            }

        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            TagFixtures::class,
        ];
    }
}
