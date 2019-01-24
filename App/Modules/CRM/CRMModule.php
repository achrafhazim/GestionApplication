<?php

namespace App\Modules\CRM;

use App\AbstractModules\AbstractModule;
use App\AbstractModules\Controller\AjaxController;
use App\AbstractModules\Controller\FileController;
use App\AbstractModules\Controller\SendController;
use App\AbstractModules\Controller\ShowController;
use Kernel\AWA_Interface\RouterInterface;

class CRMModule extends AbstractModule {

    private $Options = [];
    protected $Controllers = [
        "clients",
        'raison$sociale',
        ['contacts' => ['notSelect' => ['raison$sociale']]]
    ];

    const NameModule = "CRM";
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

    public function addRoute(RouterInterface $router) {
        $router->addRoute_get(
                /* web view
                  /controle/voir                variable GET
                  /controle/voir/:id            variable GET
                  /controle/ajouter/0             variable GET
                  /controle/modifier/:id        variable GET
                  /controle/message/:id,id      variable GET
                  /controle/delete/:id          variable GET
                  /controle/files/:id           variable GET tamarahhhhhhhhhh


                 */
                "/{controle:[a-z\$]+}[/{action:[a-z]+}/{id:[0-9\_\$\-\,]+}]", new \Kernel\Controller\WebController($this->Options), $this->getNamesRoute()->show(), self::NameModule
        );
        $router->addRoute_post(
                "/{controle:[a-z\$]+}/{action:[a-z]+}/{id:[0-9]+}", new \Kernel\Controller\WebController($this->Options), $this->getNamesRoute()->send(), self::NameModule
        );



        ///api
        $router->addRoute_RestFul(
                "/{controle:[a-z\$]+}[/{id:[0-9]+}]", new \Kernel\Controller\RestFul($this->Options),
                /// name route
                $this->getNamesRoute()->RestFull(), self::NameModule
        );
    }

}
