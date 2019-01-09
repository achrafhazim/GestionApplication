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

/**
 * Description of DELETEcontroller
 *
 * @author wassime
 */
class DELETEcontroller extends AbstractController{
    protected function supprimer($id, string $view): ResponseInterface {

        $conditon = ['id' => $id];

        $url_id_file = $this->getModel()->get_idfile($id);

        $etat = $this->getModel()->delete($conditon);

        if ($etat == -1) {
            $r = $this->getResponse()->withStatus(406);
            // satutus code par java script
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("$view  $id");

            $eventManager = $this->getContainer()->get(EventManagerInterface::class);
            $event = new Event();
            $event->setName("delete_files");
            $event->setParams(["url_id_file" => $url_id_file]);
            $eventManager->trigger($event);
        }

        return $this->getResponse();
    }
}
