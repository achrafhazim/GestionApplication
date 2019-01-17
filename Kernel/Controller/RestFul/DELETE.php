<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\RestFul;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\ModelInterface;
use Kernel\Event\Event;
use Psr\Container\ContainerInterface;

/**
 * Description of DELETEcontroller
 *
 * @author wassime
 */
class DELETE {

    private $Container;
    private $model;

    function __construct(ContainerInterface $Container, ModelInterface $model) {
        $this->Container = $Container;
        $this->model = $model;
    }

    public function run(int $id): int {

        $conditon = ['id' => $id];

        $url_id_file = $this->model->get_idfile($id);

        $etat = $this->model->delete($conditon);

        if ($etat == -1) {
//            $r = $this->getResponse()->withStatus(406);
//            // satutus code par java script
//            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return 300;
        } else {
            //$this->getResponse()->getBody()->write("ok delete  $id");

            $eventManager = $this->Container->get(EventManagerInterface::class);
            $event = new Event();
            $event->setName("delete_files");
            $event->setParams(["url_id_file" => $url_id_file]);
            $eventManager->trigger($event);
        }

        return 200;
    }

}
