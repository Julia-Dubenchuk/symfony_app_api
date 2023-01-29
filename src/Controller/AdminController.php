<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(): Response
    {
        return $this->render('admin/categories.html.twig');
    }

    /**
     * @Route("/tracks", name="tracks")
     */
    public function tracks(): Response
    {
        return $this->render('admin/tracks.html.twig');
    }

    /**
     * @Route("/upload-track", name="upload_track")
     */
    public function uploadTrack(): Response
    {
        return $this->render('admin/upload_track.html.twig');
    }

    /**
     * @Route("/users", name="users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }

     /**
     * @Route("/edit-category", name="edit_category")
     */
    public function editCategory(): Response
    {
        return $this->render('admin/edit_category.html.twig');
    }
}
