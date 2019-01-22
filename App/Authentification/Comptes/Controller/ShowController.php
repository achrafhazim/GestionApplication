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
use App\AbstractModules\Controller\ShowController as show;
use App\Authentification\Comptes\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowController extends show
{



    public function run($id): ResponseInterface
    {
     
        

        switch (true) {
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->RestFull());


            case $this->Actions()->is_update():
                return $this->modifier($id, "modifier_form");


            case $this->Actions()->is_delete():
                return $this->supprimer($id, "les données a supprimer de ID");


            case $this->Actions()->is_show():
                return $this->show($id, "show_id");


            case $this->Actions()->is_message():
                return $this->message($id, "show_message_id");


            case $this->Actions()->is_add():
                return $this->ajouter("ajouter_form", "ajouter_select");


            default:
                return $this->getResponse()->withStatus(404);
        }
    }
}
