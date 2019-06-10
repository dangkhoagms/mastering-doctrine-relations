<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends AppFixtures
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Tag::class,10,function (Tag $tag){
            $tag->setName($this->faker->realText(20));
            $tag->setSlug($this->faker->slug);

        });
        $manager->flush();
    }
}
