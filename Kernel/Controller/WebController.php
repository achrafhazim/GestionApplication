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
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;
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
            $GET = $this->getRequest()->getQueryParams();
            return $this->webGET($id, $GET);
        } elseif ($method_HTTP == "POST") {
            return $this->webPOST($id);
        } else {
            return $this->getResponse()->withStatus(404);
        }
    }

    public function webGET($param, $GET) {
        switch (true) {

            case $this->Actions()->is_message():
                $message = new web\Message($this->getModel(), $this->getNameController());
                $intentshow = $message->run($param);
                return $this->render("show_message_id", ["intent" => $intentshow]);

            case $this->Actions()->is_files():
                $files = new web\Files($this->getNameController(), $this->getFile_Upload());
                $data = $files->run($param);
                return $this->render("show_files", ["files" => $data]);

            case $this->Actions()->is_index():

                $url = $this->getRouter()
                        ->generateUri($this->getNamesRoute()->RestFull(), ["controle" => $this->getNameController()]);

                $get = "?" . $this->getRequest()->getUri()->getQuery();
                $urljson = $url . $get;
                $index = new web\Index($this->getModel());
                $data = $index->run($GET, $urljson);
                return $this->render("show", $data);

            case $this->Actions()->is_show():
                $show = new web\Show($this->getModel());
                $data = $show->run($param);
                return $this->render("show_id", ["intent" => $data]);

            case $this->Actions()->is_delete():
                $delete = new web\Delete($this->getModel());
                $etat = $delete->run($param);

                $id = $param;


                if ($etat == -1) {
                    $r = $this->getResponse()->withStatus(406);
                    $r->getBody()->write("accès refusé  de supprimer ID  $id");
                    return $r;
                } else {
                    $this->getResponse()->getBody()->write("les données a supprimer de ID  $id");
                    $url_id_file = $this->getModel()->get_idfile($id);

                    $eventManager = $this->getContainer()->get(EventManagerInterface::class);
                    $event = new Event();
                    $event->setName("delete_files");
                    $event->setParams(["url_id_file" => $url_id_file]);
                    $eventManager->trigger($event);
                }

                return $this->getResponse();


            case $this->Actions()->is_add():
                $add = new web\Add($this->getModel(), $GET, $this->getnotSelect(), $this->getChild());
                $data = $add->run();

                if ("select" == ($data["type"])) {
                    return $this->render("ajouter_select", $data);
                } elseif ("form_child" == ($data["type"])) {
                    return $this->render("ajouter_form_child", $data);
                } elseif ("ajouter" == ($data["type"])) {
                    return $this->render('ajouter_form', $data);
                }

            case $this->Actions()->is_update():
                $add = new web\Update($this->getModel(), $this->getChild());
                $data = $add->run($param);
                if ("form" == ($data["type"])) {
                    return $this->render("modifier_form", $data);
                } elseif ("form_child" == ($data["type"])) {
                    return $this->render("modifier_form_child", $data);
                }



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
        $this->setRenderer($this->getContainer()->get(\Kernel\AWA_Interface\RendererInterface::class));
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
