<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(): Response
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/playlist", name="playlist")
     */
    public function playlist(): Response
    {
        return $this->render('front/playlist.html.twig');
    }

    /**
     * @Route("/playlist-details", name="playlist_details")
     */
    public function playlistDetails(): Response
    {
        return $this->render('front/playlist_details.html.twig');
    }

    /**
     * @Route("/search-results", methods={"POST"}, name="search_results")
     */
    public function searchResults(): Response
    {
        return $this->render('front/search_results.html.twig');
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing(): Response
    {
        return $this->render('front/pricing.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    {
        return $this->render('front/register.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('front/login.html.twig');
    }
}
