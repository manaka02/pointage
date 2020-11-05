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
    public function list(Request $request) : Response
    {
        return $this->render("pages/recap/presence.html.twig");
    }
}
