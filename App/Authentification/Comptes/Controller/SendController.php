<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification\Comptes\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use App\AbstractModules\Controller\SendController as send;
use App\Authentification\Comptes\Model\Model;
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendController extends send
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
        parent::process($request, $handler);
        return $this->send_data("show_item", $this->getNamesRoute()->files());
    }

    public function send_data(string $view_show, string $routeFile = ""): ResponseInterface
    {
        $view = parent::send_data($view_show, $routeFile);
        /// is new compte danc set data default autorisation$modul
        $eventManager = $this->getContainer()->get(EventManagerInterface::class);
        $eventManager->trigger("autorisation_init");
        return $view;
    }
}
