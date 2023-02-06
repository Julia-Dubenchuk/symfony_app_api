<?php

namespace App\Tests\Utils;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Twig\AppExtension;

class CategoryTest extends KernelTestCase
{
    protected $mockedCategoryTreeFrontPage;
    protected $mockedCategoryTreeAdminList;
    protected $mockedCategoryTreeAdminOptionList;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $urlgenerator = $kernel->getContainer()->get('router');
        $tested_classes = [
            'CategoryTreeAdminList',
            'CategoryTreeAdminOptionList',
            'CategoryTreeFrontPage'
        ];

        foreach($tested_classes as $class)
        {
            $name = 'mocked'.$class;
            $this->$name = $this->getMockBuilder('App\Utils\\'.$class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

            $this->$name->urlgenerator = $urlgenerator;
        }
    }

    /**
     * @dataProvider dataForCategoryTreeFrontPage
     */
    public function testCategoryTreeFrontPage($string, $array, $id)
    {
        $this->mockedCategoryTreeFrontPage->categoriesArrayFromDb = $array;
        $this->mockedCategoryTreeFrontPage->slugger = new AppExtension;
        $main_parent_id = $this->mockedCategoryTreeFrontPage->getMainParent($id)['id'];
        $array = $this->mockedCategoryTreeFrontPage->buildTree($main_parent_id);
        $this->assertSame($string, $this->mockedCategoryTreeFrontPage->getCategoryList($array));
    }

    /**
     * @dataProvider dataForCategoryTreeAdminOptionList
     */
    public function testCategoryTreeAdminOptionList($arrayToCompare, $arrayFromDb)
    {
        $this->mockedCategoryTreeAdminOptionList->categoriesArrayFromDb = $arrayFromDb;
        $arrayFromDb = $this->mockedCategoryTreeAdminOptionList->buildTree();

        $this->assertSame($arrayToCompare, $this->mockedCategoryTreeAdminOptionList->getCategoryList($arrayFromDb));
    }

    /**
     * @dataProvider dataForCategoryTreeAdminList
     */
    public function testCategoryTreeAdminList($string, $array)
    {
        $this->mockedCategoryTreeAdminList->categoriesArrayFromDb = $array;
        $array = $this->mockedCategoryTreeAdminList->buildTree();
        $this->assertSame($string, $this->mockedCategoryTreeAdminList->getCategoryList($array));
    }

    public function dataForCategoryTreeFrontPage()
    {
        yield [
           '<ul><li><a href="/playlist/category/anime,5">anime</a></li><li><a href="/playlist/category/pop,6">pop</a><ul><li><a href="/playlist/category/fresh-pop,8">fresh-pop</a><ul><li><a href="/playlist/category/feel-good,10">feel-good</a></li><li><a href="/playlist/category/feeling-blue,11">feeling-blue</a></li><li><a href="/playlist/category/acoustic,12">acoustic</a></li><li><a href="/playlist/category/at-home,13">at-home</a></li><li><a href="/playlist/category/focus,14">focus</a></li></ul></li><li><a href="/playlist/category/global-hits,9">global-hits</a></li></ul></li><li><a href="/playlist/category/cozy-coffeshop,7">cozy-coffeshop</a></li></ul>',
           [
            ['name' => 'Chill', 'id' => 1, 'parent_id' => null],
            ['name' => 'Lofi', 'id' => 2, 'parent_id' => null],
            ['name' => 'Workout', 'id' => 3, 'parent_id' => null],
            ['name' => 'Party', 'id' => 4, 'parent_id' => null],
            ['name' => 'Anime', 'id' => 5, 'parent_id' => 1],
            ['name' => 'Pop', 'id' => 6, 'parent_id' => 1],
            ['name' => 'Cozy coffeshop', 'id' => 7, 'parent_id' => 1],
            ['name' => 'Fresh Pop', 'id' => 8, 'parent_id' => 6],
            ['name' => 'Global Hits', 'id' => 9, 'parent_id' => 6],
            ['name' => 'Feel Good', 'id' => 10, 'parent_id' => 8],
            ['name' => 'Feeling Blue', 'id' => 11, 'parent_id' => 8],
            ['name' => 'Acoustic', 'id' => 12, 'parent_id' => 8],
            ['name' => 'At home', 'id' => 13, 'parent_id' => 8],
            ['name' => 'Focus', 'id' => 14, 'parent_id' => 8],
            ['name' => 'Young and Free', 'id' => 15, 'parent_id' => null],
            ['name' => 'Happy Hour', 'id' => 16, 'parent_id' => null],
            ['name' => 'Lowkey', 'id' => 17, 'parent_id' => 4],
            ['name' => 'No Stress', 'id' => 18, 'parent_id' => 4],
            ['name' => 'Rock', 'id' => 19, 'parent_id' => 3],
            ['name' => 'Metal', 'id' => 20, 'parent_id' => 3],
           ],
           1
        ];
    }

    public function dataForCategoryTreeAdminOptionList()
    {
        yield [
            [
                ['name' => 'Chill', 'id' => 1],
                ['name' => '--Anime', 'id' => 5],
                ['name' => '--Pop', 'id' => 6],
                ['name' => '----Fresh Pop', 'id' => 8],
                ['name' => '------Feel Good', 'id' => 10],
                ['name' => '------Feeling Blue', 'id' => 11],
                ['name' => '------Acoustic', 'id' => 12],
                ['name' => '------At home', 'id' => 13],
                ['name' => '------Focus', 'id' => 14],
                ['name' => '----Global Hits', 'id' => 9],
                ['name' => '--Cozy coffeshop', 'id' => 7],
                ['name' => 'Lofi', 'id' => 2],
                ['name' => 'Workout', 'id' => 3],
                ['name' => '--Rock', 'id' => 19],
                ['name' => '--Metal', 'id' => 20],
                ['name' => 'Party', 'id' => 4],
                ['name' => '--Lowkey', 'id' => 17],
                ['name' => '--No Stress', 'id' => 18],
                ['name' => 'Young and Free', 'id' => 15],
                ['name' => 'Happy Hour', 'id' => 16],
            ],
            [
                ['name' => 'Chill', 'id' => 1, 'parent_id' => null],
                ['name' => 'Lofi', 'id' => 2, 'parent_id' => null],
                ['name' => 'Workout', 'id' => 3, 'parent_id' => null],
                ['name' => 'Party', 'id' => 4, 'parent_id' => null],
                ['name' => 'Anime', 'id' => 5, 'parent_id' => 1],
                ['name' => 'Pop', 'id' => 6, 'parent_id' => 1],
                ['name' => 'Cozy coffeshop', 'id' => 7, 'parent_id' => 1],
                ['name' => 'Fresh Pop', 'id' => 8, 'parent_id' => 6],
                ['name' => 'Global Hits', 'id' => 9, 'parent_id' => 6],
                ['name' => 'Feel Good', 'id' => 10, 'parent_id' => 8],
                ['name' => 'Feeling Blue', 'id' => 11, 'parent_id' => 8],
                ['name' => 'Acoustic', 'id' => 12, 'parent_id' => 8],
                ['name' => 'At home', 'id' => 13, 'parent_id' => 8],
                ['name' => 'Focus', 'id' => 14, 'parent_id' => 8],
                ['name' => 'Young and Free', 'id' => 15, 'parent_id' => null],
                ['name' => 'Happy Hour', 'id' => 16, 'parent_id' => null],
                ['name' => 'Lowkey', 'id' => 17, 'parent_id' => 4],
                ['name' => 'No Stress', 'id' => 18, 'parent_id' => 4],
                ['name' => 'Rock', 'id' => 19, 'parent_id' => 3],
                ['name' => 'Metal', 'id' => 20, 'parent_id' => 3],
               ],
        ];
    }

    public function dataForCategoryTreeAdminList()
    {
        yield [
            '<ul class="fa-ul text-left"><li><i class="fa-li fa fa-arrow-right"></i>Chill<a href="/admin/edit-category/1"> Edit</a> <a onclick="return confirm(\'Are you sure?\');" href="/admin/delete-category/1">Delete</a></li></ul>', 
            [['name' => 'Chill', 'id' => 1, 'parent_id' => null]],
        ];
    }
}
