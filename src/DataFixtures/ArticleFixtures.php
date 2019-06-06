<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

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
