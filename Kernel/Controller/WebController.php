<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

/**
 * Description of WebController
 *
 * @author wassime
 */
use Kernel\AWA_Interface\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use const D_S;
use const ROOT_WEB;
use function array_merge;
use function str_replace;
use function ucfirst;

class WebController extends Controller {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));




        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $action = $this->getRoute()->getParam("action");
        $this->Actions()->setAction($action);
        $id = $this->getRoute()->getParam("id");
        $method_HTTP = $this->getRequest()->getMethod();

        if ($method_HTTP == "GET") {
            return $this->webGET($id);
        } elseif ($method_HTTP == "POST") {
            return $this->webPOST($id);
        } else {
           return $this->getResponse()->withStatus(404);
        }

        
    }

    public function webGET($param) {
      switch (true) {
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->RestFull());


            case $this->Actions()->is_update():
                if ($this->getChild() !== false) {
                    return $this->modifier_child($id, "modifier_form_child");
                } else {
                    return $this->modifier($id, "modifier_form");
                }


            case $this->Actions()->is_delete():
                return $this->supprimer($id, "les données a supprimer de ID");


            case $this->Actions()->is_show():
                return $this->show($id, "show_id");


            case $this->Actions()->is_message():
                return $this->message($id, "show_message_id");


            case $this->Actions()->is_add():
                if ($this->getChild() !== false) {
                    return $this->ajouter_child("ajouter_form_child", "ajouter_select");
                } else {
                    return $this->ajouter("ajouter_form", "ajouter_select");
                }

            case $this->Actions()->is_files():
                $id = $this->getRoute()->getParam("id");
                return $this->files($id, "show_files");

            default:
                return $this->getResponse()->withStatus(404);
        }  
    }

    public function webPOST($param) {
        
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private $renderer;
    private $data_views = [];

    function __construct(array $Options) {
        parent::__construct($Options);
        $this->setRenderer($this->getContainer()->get(RendererInterface::class));
    }

    /// view
    function add_data_views(array $data_views): array {

        $this->data_views = array_merge($this->data_views, $data_views);
        return $this->data_views;
    }

    function getRenderer(): RendererInterface {
        return $this->renderer;
    }

    function setRenderer(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }

    public function render($name_view, array $data = []): ResponseInterface {
        $renderer = $this->getRenderer();

        $renderer->addGlobal("_page", ucfirst(str_replace("$", "  ", $this->getNameController())));
        $renderer->addGlobal("_Controller", $this->getNameController());
        $renderer->addGlobal("_Action", $this->Actions());
        $renderer->addGlobal("_ROOTWEB", ROOT_WEB);

        $renderer->addGlobal("_NamesRoute", $this->getNamesRoute());
        $data_view = $this->add_data_views($data);


        $pathview = $this->getContainer()->get("Modules") .
                $this->getNameModule() . D_S .
                "views" . D_S .
                $this->getNameController() . D_S;

        if (is_dir($pathview)) {
            $render = $renderer->render("@{$this->getNameModule()}{$this->getNameController()}/" . $name_view, $data_view);
        } else {
            $render = $renderer->render("@default_view/" . $name_view, $data_view);
        }



        $response = $this->getResponse();
        $response->getBody()->write($render);
        return $response;
    }

}
