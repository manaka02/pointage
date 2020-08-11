<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EmployeController extends AbstractController
{
    /**
     * @Route("/employe-list", name="employe-list", methods="GET")
     */
    public function list(Request $request) : Response
    {
        return $this->render("pages/employe/list.html.twig");
    }
}   