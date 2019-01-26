<?php

namespace App\Modules\Reglages;

use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Controller\RestFul;
use Kernel\Controller\WebController;
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
        /* web view
          /controle/voir                variable GET
          /controle/voir/:id            variable GET
          /controle/ajouter/0             variable GET
          /controle/modifier/:id        variable GET
          /controle/message/:id,id      variable GET
          /controle/delete/:id          variable GET
          /controle/files/:id           variable GET tamarahhhhhhhhhh


         */
        $router->addRoute_Web(
                "/{controle:[a-z\$]+}[/{action:[a-z]+}/{id:[0-9\_\$\-\,]+}]", new WebController($this->Options), $this->getNamesRoute()->show(), self::NameModule
        );


        /*
         * api
         * GET
         * POST
         * PUT
         * DELETE
         */
        $router->addRoute_RestFul(
                "/{controle:[a-z\$]+}[/{id:[0-9]+}]", new RestFul($this->Options),
                /// name route
                $this->getNamesRoute()->RestFull(), self::NameModule
        );
    }
}
