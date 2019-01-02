<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of GET
 *
 * @author wassime
 */
class GET extends AbstractController{

    public function run($id): ResponseInterface {
        switch (true) {
            case $this->Actions()->is_ajax():
                return $this->ajax_js();
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->ajax());


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



            default:
                return $this->getResponse()->withStatus(404);
        }
    }

}
