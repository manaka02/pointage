<?php

namespace App\Controller;

use App\Services\BoardService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RecapController extends AbstractController
{

    /**
     * @Route("/recap-presence", name="recap-presence", methods="GET")
     */
    public function presence(Request $request) : Response
    {
        return $this->render("pages/recap/presence.html.twig");
    }

    /**
     * @Route("/recap-absence", name="recap-absence", methods="GET")
     */
    public function absence(Request $request) : Response
    {
        return $this->render("pages/recap/absence.html.twig");
    }
}
