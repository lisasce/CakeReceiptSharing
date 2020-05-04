<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SkipWelcomeController extends AbstractController
{
    /**
     * @Route("/", name="skip_welcome")
     */
    public function index()
    {
    return $this->render("skip_welcome/index.html.twig");

    }
}
