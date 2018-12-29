<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author wassime
 */

namespace App\Modules\Rapports;

use App\AbstractModules\AbstractModule;
use App\Modules\Rapports\Controller\AjaxController;
use App\Modules\Rapports\Controller\globalController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class RapportsModule extends AbstractModule
{

    protected $Controllers = [
        "clients",
        /* 'raison$sociale',
        'contacts',
        'mode$paiement' */
    ];
    const NameModule = "Rapports";
    const IconModule = " fa fa-fw fa-bar-chart-o ";

    public function addPathRenderer(RendererInterface $renderer,string $path)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;

        $renderer->addPath($pathModule, self::NameModule);

       // $NamesControllers=$this->getNamesControllers($this->Controllers);
       // foreach ($NamesControllers as $NameController ) {

          //$pathModule = __DIR__ . D_S . "views" . D_S.$NameController.D_S;

         // $renderer->addPath($pathModule, self::NameModule.$NameController);
     //   }

    }

    public function addRoute(RouterInterface $router)
    {

        $nameRoute=$this->getNamesRoute();
        $Options=["container"=>$this->getContainer(),
            "namesControllers"=>$this->Controllers,
            "nameModule"=> self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute"=>$nameRoute
            ];

        $router->addRoute_any("{controle:[a-z\$]*}", new globalController($Options), $nameRoute->show());

        $router->addRoute_any("st/{controle:[a-z\$]*}", new AjaxController($Options), "st.get");
    }
}
