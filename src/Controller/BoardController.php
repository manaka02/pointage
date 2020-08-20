<?php

namespace App\Controller;

use App\Services\BoardService;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request) : Response
    {
        error_log("boarrrd");
        $params = $request->query->all();
        $service = new BoardService();
        $allData = $service->getData($params);

        return $this->render("pages/board.html.twig",
        [
            "data" => $allData
        ]    
    );
    }
}


