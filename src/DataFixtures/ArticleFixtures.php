<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends AppFixtures
{
    private static $Article_titles = [
        'foo one',
        'foo two'
    ];
    private static $Article_heart = [0,10,20,100];


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class,100,function (Article $article, $count) use ($manager){
            $article->setName($this->faker->randomElement(self::$Article_titles));
            $article->setContent(sprintf($this->faker->paragraph));
            $article->setPublishedAt(new \DateTime());
            $article->setHeartCount($this->faker->randomElement(self::$Article_heart));
            $article->setSlug($this->faker->slug);
            $manager->persist($article);
        });

        $manager->flush();
    }
}
