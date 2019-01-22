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
        $nameRoute = $this->getNamesRoute();










        $router->addRoute_get(
                /* web view
                  /controle/voir                variable GET
                  /controle/ajouter-            variable GET
                  /controle/modifier-:id        variable GET
                  /controle/message-:id,id        variable GET
                  /controle/delete-:id          variable GET
                  /controle/delete?startid=:id&stopid=:id variable GET
                 * 
                 */
                "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]", new ShowController($this->Options), $nameRoute->show(), self::NameModule
        );
        $router->addRoute_post(
                "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}", new SendController($this->Options), $nameRoute->send(), self::NameModule
        );
        $router->addRoute_get(
                "/files/{controle:[a-z0-9\_\$\-]+}", new FileController($this->Options), $nameRoute->files(), self::NameModule
        );

        ///api
        $router->addRoute_RestFul(
                "/{controle:[a-z\$]+}[/{id:[0-9]+}]", new \Kernel\Controller\RestFul($this->Options),
                /// name route
                $nameRoute->get(), self::NameModule
        );
    }

}
