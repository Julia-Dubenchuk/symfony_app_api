<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Playlist;
use App\Entity\Category;

class PlaylistFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach($this->PlaylistData() as [$title, $link, $category_id]) 
        {
            $duration = random_int(10, 300);
            $category = $manager->getRepository(Category::class)->find($category_id);
            $playlist = new Playlist();
            $playlist->setTitle($title);
            $playlist->setLink(''.$link);
            $playlist->setCategory($category);
            $playlist->setDuration($duration);
            $manager->persist($playlist);
        }

        $manager->flush();
    }

    private function PlaylistData()
    {
        return [
            ['Playlist 1', 123456789,4],
            ['Playlist 2', 123456789,4],
            ['Playlist 3', 123456789,4],
            ['Playlist 4', 123456789,4],
            ['Playlist 5', 123456789,4],
        ];
    }
}
