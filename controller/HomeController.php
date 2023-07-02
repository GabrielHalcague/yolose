<?php


class HomeController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function list()
    {
        if (empty(Session::get('logged'))) {
            Header::redirect("inicio");
        }
        $this->renderer->render("home");
        exit();
    }

}