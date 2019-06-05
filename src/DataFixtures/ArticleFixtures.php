<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i<=10;$i++){
            $article = new Article();
            $article->setName(sprintf("foo%d",$i));
            $article->setContent(sprintf("baz%d",$i));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
