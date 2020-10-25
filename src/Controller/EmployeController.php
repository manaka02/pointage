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

     /**
     * @Route("/employe-detail", name="employe-detail", methods="GET")
     */
    public function detail(Request $request) : Response
    {
        return $this->render("pages/employe/detail.html.twig");
    }

     /**
     * @Route("/employe-edit", name="employe-edit", methods="GET")
     */
    public function edit(Request $request) : Response
    {
        return $this->render("pages/employe/detail.html.twig");
    }

     /**
     * @Route("/employe-delete", name="employe-delete", methods="DELETE")
     */
    public function delete(Request $request) : Response
    {
        return $this->render("pages/employe/detail.html.twig");
    }
}   