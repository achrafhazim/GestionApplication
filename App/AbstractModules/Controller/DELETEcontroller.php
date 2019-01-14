<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of DELETEcontroller
 *
 * @author wassime
 */
class DELETEcontroller extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
        $method_HTTP = $this->getRequest()->getMethod();
        $id = (int) $this->getRoute()->getParam("id");



        $classModel = $this->getClassModel();
        $this->setModel(new $classModel($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
        $this->chargeModel($this->getNameController());


        if ($this->is_Erreur()) {
            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }



        if ($method_HTTP === "DELETE") {

            return $this->DELETE_REST($id);
        }
    }

    protected function DELETE_REST($id): ResponseInterface {

        $conditon = ['id' => $id];

        $url_id_file = $this->getModel()->get_idfile($id);

        $etat = $this->getModel()->delete($conditon);

        if ($etat == -1) {
            $r = $this->getResponse()->withStatus(406);
            // satutus code par java script
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("ok delete  $id");

            $eventManager = $this->getContainer()->get(EventManagerInterface::class);
            $event = new Event();
            $event->setName("delete_files");
            $event->setParams(["url_id_file" => $url_id_file]);
            $eventManager->trigger($event);
        }

        return $this->getResponse();
    }

}
