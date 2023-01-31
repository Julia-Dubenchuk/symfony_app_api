<?php
namespace App\Utils;

use App\Twig\AppExtension;
use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract {
    public $html_1 = '<ul>';
    public $html_2 = '<li>';
    public $html_3 = '<a href="';
    public $html_4 = '">';
    public $html_5 = '</a>';
    public $html_6 = '</li>';
    public $html_7 = '</ul>';

    public function getCategoryListAndParent(int $id): string
    {
        $this->slugger = new AppExtension;
        $parentData = $this->getMainParent($id);
        $this->mainParentName = $parentData['name'];
        $this->mainParentId = $parentData['id'];
        $key = array_search($id, array_column($this->categoriesArrayFromDb, 'id'));
        $this->currentCategoryName = $this->categoriesArrayFromDb[$key]['name'];
        $categories_array = $this->buildTree($parentData['id']);

        return $this->getCategoryList($categories_array);
    }

    public function getCategoryList(array $categories_array)
    {
        $this->categorylist .= $this->html_1;

        foreach($categories_array as $value)
        {
            $catName = $this->slugger->slugify($value['name']);
            $url = $this->urlgenerator->generate('playlist',
            ['categoryname'=>$catName, 'id'=>$value['id']]);

            $this->categorylist .= $this->html_2 . $this->html_3 . $url . $this->html_4 . $catName . $this->html_5;

            if (!empty($value['children']))
            {
                $this->getCategoryList($value['children']);
            }

            $this->categorylist .= $this->html_6;
        }

        $this->categorylist .= $this->html_7;

        return $this->categorylist;
    }

    public function getMainParent(int $id): array
    {
        $key = array_search($id, array_column($this->categoriesArrayFromDb, 'id'));

        if($this->categoriesArrayFromDb[$key]['parent_id'] != null)
        {
            return $this->getMainParent($this->categoriesArrayFromDb[$key]['parent_id']);
        }
        else
        {
            return [
                'id' => $this->categoriesArrayFromDb[$key]['id'],
                'name' => $this->categoriesArrayFromDb[$key]['name'],
            ];
        }
    }
}
