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
     private $Options = [];
    protected $Controllers = [
        "comptes"];

    const NameModule = "Comptes";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    
      function __construct($container) {
        parent::__construct($container);

        $this->Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $this->getNamesRoute()
        ];
    }
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



     


        $router->addRoute_get(
            "/{controle:[a-zA-Z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
            new ShowController($this->Options),
            $nameRoute->show(),
            self::NameModule
        );


        $router->addRoute_post(
            "/{controle:[a-zA-Z\$]+}/{action:[a-z]+}-{id:[0-9]+}",
            new SendController($this->Options),
            $nameRoute->send(),
            self::NameModule
        );


  


        

        /*
         * login
         */
        $router->addRoute_get(
            "/login",
            new Controller\LoginFormController($this->Options),
            "login",
            "login"
        );


        $router->addRoute_post(
            "/login",
            new Controller\LoginSendController($this->Options),
            "loginPost",
            "login"
        );
          ///api
        $router->addRoute_RestFul(
                "/{controle:[a-z\$]+}[/{id:[0-9]+}]", new \Kernel\Controller\RestFul\RestFul($this->Options),
                /// name route
                $nameRoute->RestFull(), self::NameModule
        );
    }
}
