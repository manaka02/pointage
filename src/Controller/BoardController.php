<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BoardController extends AbstractController
{

    private $service;
    public function __construct() {
        // $this->service = new BoardService();
    }

    /**
     * @Route("/", name="board")
     */
    public function index($params = []) : Response
    {
        // formation
        // $countFormation = (new FormationOsc())->countOscPerFormationTheme($con);
        return $this->render("pages/board.html.twig");
    }
}


