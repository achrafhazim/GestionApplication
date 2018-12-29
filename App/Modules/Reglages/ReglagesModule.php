<?php

namespace App\Modules\Reglages;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\AbstractModules\Controller\SendController;
use App\AbstractModules\Controller\ShowController;
use App\AbstractModules\Controller\AjaxController;
use App\AbstractModules\Controller\FileController;
class ReglagesModule extends AbstractModule
{

    protected $Controllers = [
        'categories$des$depenses',
        'categories$des$recettes',
        'comptes$bancaires',
        'type$produit',
        'taxes',
        'unites',
        'mode$paiement'];

    const NameModule = "Reglages";
    const IconModule = " fa fa-fw fa-stack-overflow ";

   

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
