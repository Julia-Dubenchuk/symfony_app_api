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
        $this->loadChill($manager);
        $this->loadPop($manager);
        $this->loadFreshPop($manager);
        $this->loadNoStress($manager);
        $this->loadParty($manager);
        $this->loadWorkout($manager);
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

    private function loadSubcategories(ObjectManager $manager, $category, $parent_id)
    {
        $parent = $manager->getRepository(Category::class)->find($parent_id);
        $methodName = "get{$category}Data";

        foreach($this->$methodName() as [$name])
        {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }
    

        $manager->flush();
    }

    private function loadChill(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Chill', 1);
    }

    private function loadPop(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Pop', 6);
    }

    private function loadFreshPop(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'FreshPop', 8);
    }

    private function loadWorkout(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Workout', 3);
    }

    private function loadParty(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'Party', 4);
    }

    private function loadNoStress(ObjectManager $manager)
    {
        $this->loadSubcategories($manager, 'NoStress', 18);
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

    private function getChillData()
    {
        return [
            ['Anime', 5],
            ['Pop', 6],
            ['Cozy coffeshop', 7],
        ];
    }

    private function getPopData()
    {
        return [
            ['Fresh Pop', 8],
            ['Global Hits', 9],
        ];
    }

    private function getFreshPopData()
    {
        return [
            ['Feel Good', 10],
            ['Feeling Blue', 11],
            ['Acoustic', 12],
            ['At home', 13],
            ['Focus', 14],
        ];
    }

    private function getWorkoutData()
    {
        return [
            ['Rock', 15],
            ['Metal', 16],
        ];
    }

    private function getPartyData()
    {
        return [
            ['Lowkey', 17],
            ['No Stress', 18],
        ];
    }

    private function getNoStressData()
    {
        return [
            ['Young and Free', 19],
            ['Happy Hour', 20],
        ];
    }
}
