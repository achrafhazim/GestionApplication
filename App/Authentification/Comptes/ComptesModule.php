<?php

namespace App\Authentification\Comptes;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use App\Authentification\AutorisationInterface;
use Kernel\AWA_Interface\RendererInterface;
use App\Authentification\Comptes\Controller\SendController;
use App\Authentification\Comptes\Controller\ShowController;
use App\Authentification\Comptes\Controller\AjaxController;
use App\Authentification\Comptes\Controller\FileController;

class ComptesModule extends AbstractModule
{

    private $modules = [];
    protected $Controllers = [
        "comptes"];

    const NameModule = "Comptes";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    function setController($Controller)
    {
        $this->Controllers[] = $Controller;
    }

    function setModules(array $modules)
    {
        $this->modules = $modules;
        foreach ($modules as $module) {
            $this->setController(AutorisationInterface::Prefixe . $module::NameModule);
        }
    }

    public function addPathRenderer(RendererInterface $renderer,string $path)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }

    public function addRoute(RouterInterface $router)
    {
        $nameRoute = $this->getNamesRoute();


        $this->Controllers = $this->Controllers;



        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $nameRoute,
        ];


        $router->addRoute_get(
            "/{controle:[a-zA-Z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
            new ShowController($Options),
            $nameRoute->show(),
            self::NameModule
        );


        $router->addRoute_post(
            "/{controle:[a-zA-Z\$]+}/{action:[a-z]+}-{id:[0-9]+}",
            new SendController($Options),
            $nameRoute->send(),
            self::NameModule
        );


        $router->addRoute_get(
            "/ajax/{controle:[a-zA-Z\$]+}",
            new AjaxController($Options),
            $nameRoute->ajax(),
            self::NameModule
        );


        $router->addRoute_get(
            "/files/{controle:[a-zA-Z0-9\_\$\-]+}",
            new FileController($Options),
            $nameRoute->files(),
            self::NameModule
        );

        /*
         * login
         */
        $router->addRoute_get(
            "/login",
            new Controller\LoginFormController($Options),
            "login",
            "login"
        );


        $router->addRoute_post(
            "/login",
            new Controller\LoginSendController($Options),
            "loginPost",
            "login"
        );
    }
}
