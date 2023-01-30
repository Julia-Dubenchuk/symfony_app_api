<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadMainCategories($manager);
    }

    private function loadMainCategories(ObjectManager $manager)
    {
        foreach($this->getMainCategoriesData() as [$name])
        {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
    

        $manager->flush();
    }

    private function getMainCategoriesData()
    {
        return [
            ['Chill', 1],
            ['Lofi', 2],
            ['Workout', 3],
            ['Party', 4],
        ];
    }
}
