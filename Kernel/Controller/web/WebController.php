<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web;

/**
 * Description of WebController
 *
 * @author wassime
 */

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\Controller\web\GET\Add as Add2;
use Kernel\Controller\web\GET\Delete;
use Kernel\Controller\web\GET\Files;
use Kernel\Controller\web\GET\Index;
use Kernel\Controller\web\GET\Message;
use Kernel\Controller\web\GET\Show;
use Kernel\Controller\web\GET\Update as Update2;
use Kernel\Controller\web\POST\Add;
use Kernel\Controller\web\POST\Update;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\Event\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\AWA_Interface\ActionInterface;
use const D_S;
use const ROOT_WEB;
use function str_replace;
use function ucfirst;

class WebController extends \Kernel\Controller\Controller {

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// view
    private $renderer;
    
    private $namesRoute;

    function __construct(array $Options) {
        
        
        parent::__construct($Options);
         
        
        $this->namesRoute = $Options["nameRoute"];
        
        $this->renderer = $this->getContainer()->get(RendererInterface::class);
        //$this->setRenderer($this->getContainer()->get(\Kernel\AWA_Interface\RendererInterface::class));
    }
   function Actions(): ActionInterface {
       return $this->getContainer()->get(ActionInterface::class);
        
    }

    function getNamesRoute(): NamesRouteInterface {
        
        return $this->namesRoute;
    }
    
    
    
    
    
    
    
    public function render($name_view, array $data_view = []): ResponseInterface {
        $renderer = $this->renderer;

        $renderer->addGlobal("_page", ucfirst(str_replace("$", "  ", $this->getNameController())));
        $renderer->addGlobal("_Controller", $this->getNameController());
        $renderer->addGlobal("_Action", $this->Actions());
        $renderer->addGlobal("_ROOTWEB", ROOT_WEB);
        $renderer->addGlobal("_NamesRoute", $this->getNamesRoute());





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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        

        
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
                $message = new Message($this->getModel(), $this->getNameController());
                $intentshow = $message->run($param);
                return $this->render("show_message_id", ["intent" => $intentshow]);
            case $this->Actions()->is_files():
                $files = new Files($this->getNameController(), $this->getFile_Upload());
                $data = $files->run($param);
                return $this->render("show_files", ["files" => $data]);
            case $this->Actions()->is_index():

                $url = $this->getRouter()
                        ->generateUri($this->getNamesRoute()->RestFull(), ["controle" => $this->getNameController()]);

                $get = "?" . $this->getRequest()->getUri()->getQuery();
                $urljson = $url . $get;
                $index = new Index($this->getModel());
                $data = $index->run($GET, $urljson);
                return $this->render("show", $data);
            case $this->Actions()->is_show():
                $show = new Show($this->getModel());
                $data = $show->run($param);
                return $this->render("show_id", ["intent" => $data]);
            case $this->Actions()->is_delete():
                $delete = new Delete($this->getModel());
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
                $add = new Add2($this->getModel(), $GET, $this->getnotSelect(), $this->getChild());
                $data = $add->run();
                return $this->render('ajouter_new', $data);

                
                
//                if ("select" == ($data["type"])) {
//                    return $this->render("ajouter_select", $data);
//                } elseif ("form_child" == ($data["type"])) {
//                    return $this->render("ajouter_form_child", $data);
//                } elseif ("ajouter" == ($data["type"])) {
//                    return $this->render('ajouter_form', $data);
//                }
                
                
            case $this->Actions()->is_update():
                $add = new Update2($this->getModel(), $this->getChild());
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

    public function webPOST($id) {
        if ($id == 0) {
            $add = new Add(
                    $this->getContainer(), $this->getModel(), $this->getChild(), $this->getNameController(), $this->getFile_Upload(), $this->getRequest()->getUploadedFiles(), $this->getRequest()->getParsedBody(), $this->getRouter(), $this->Actions()
            );

            $re = $add->run($this->getNamesRoute()->show());
            return $this->render("show_item", $re);
        } else {
            $add = new Update(
                    $this->getContainer(), $this->getModel(), $this->getChild(), $this->getNameController(), $this->getFile_Upload(), $this->getRequest()->getUploadedFiles(), $this->getRequest()->getParsedBody(), $this->getRouter(), $this->Actions()
            );

            $re = $add->run($this->getNamesRoute()->show());
            return $this->render("show_item", $re);
        }
    }

}
