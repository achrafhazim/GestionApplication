<?php

namespace App\Modules\Achats;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Modules\Achats\Controller\SendController;
use App\Modules\Achats\Controller\ShowController;
use App\Modules\Achats\Controller\AjaxController;
use App\Modules\Achats\Controller\FileController;

class AchatsModule extends AbstractModule
{



    protected $Controllers = [
          ['commandes'=>['child'=>'list$articles','notSelect'=>['raison$sociale']]],
          ['bons$achats'=>['child'=>'list$articles']],
          ['factures$achats'=>['child'=>'list$articles']],
          ['avoirs$achats'=>['child'=>'list$articles']],


    ];
    const NameModule = "Achats";
    const IconModule = " fa fa-fw fa-shopping-cart ";


    


    public function addRoute(RouterInterface $router)
    {

        $nameRoute = $this->getNamesRoute();
        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $nameRoute
        ];


        $router->addRoute_get(
            "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
            new ShowController($Options),
            $nameRoute->show(),
            self::NameModule
        );


        $router->addRoute_post(
            "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}",
            new SendController($Options),
            $nameRoute->send(),
            self::NameModule
        );


        $router->addRoute_get(
            "/ajax/{controle:[a-z\$]+}",
            new AjaxController($Options),
            $nameRoute->ajax(),
            self::NameModule
        );


        $router->addRoute_get(
            "/files/{controle:[a-z0-9\_\$\-]+}",
            new FileController($Options),
            $nameRoute->files(),
            self::NameModule
        );
    }
}
