<?php

namespace App\Modules\CRM;

use App\AbstractModules\AbstractModule;
use App\AbstractModules\Controller\AjaxController;
use App\AbstractModules\Controller\FileController;
use App\AbstractModules\Controller\SendController;
use App\AbstractModules\Controller\ShowController;
use Kernel\AWA_Interface\RouterInterface;

class CRMModule extends AbstractModule {

    protected $Controllers = [
        "clients",
        'raison$sociale',
        ['contacts' => ['notSelect' => ['raison$sociale']]]
    ];

    const NameModule = "CRM";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    public function addRoute(RouterInterface $router) {
        $nameRoute = $this->getNamesRoute();

        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $nameRoute
        ];
       //display
            //JSON
            //   affiche liset      methode get        /api/controle        variable GET
            //                                         /api/controle/json/:id     variable GET
            //                                         /api/controle/json?startid=:id&stopid=:id variable GET
            //HTML
            //   affiche liset      methode get        /api/controle/new            variable GET
            //                                         /api/controle/edit/:id      variable GET
            //                                         /api/controle/delete/:id     variable GET
            //                                         /api/controle/delete?startid=:id&stopid=:id variable GET
        //action
            //JSON
            //   action add         methode post  /api/controle              variable GET
            //   action update      methode put   /api/controle/:id          variable GET
            //   action delete      methode delete  /api/controle/:id        variable GET
           
        
        $router->addRoute_get(
                "/api/{controle:[a-z\$]+}/{action:[a-z]+}[/{id:[0-9\,]+}]",
                new \App\AbstractModules\Controller\GETcontroller($Options),
                /// name route
                $nameRoute->get() ,
                self::NameModule
        );
        $router->addRoute_post(
                "/api/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
                new \App\AbstractModules\Controller\POSTcontroller($Options),
                /// name route
                $nameRoute->post() ,
                self::NameModule
        );
        $router->addRoute_put(
                "/api/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
                new \App\AbstractModules\Controller\PUTcontroller($Options),
                /// name route
                $nameRoute->put() ,
                self::NameModule
        );
        $router->addRoute_delete(
                "/api/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
                new \App\AbstractModules\Controller\DELETEcontroller($Options),
                /// name route
                $nameRoute->delete() ,
                self::NameModule
        );
  
        
        
        
        
        
        
        $router->addRoute_get(
                "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
                new ShowController($Options),
                /// name route
                $nameRoute->show() ,
                self::NameModule
        );
        
        
        
        
//        $router->addRoute_get(
//                "/_clients[/{action:[a-z]+}-{id:[0-9\,]+}]", new Controller\Clients($Options), $nameRoute->show(), self::NameModule
//        );

        $router->addRoute_post(
                "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}", new SendController($Options), $nameRoute->send(), self::NameModule
        );

        
         $router->addRoute_any(
                "/ajax/{controle:[a-z\$]+}", new AjaxController($Options), $nameRoute->ajax(), self::NameModule
        );

//        $router->addRoute_get(
//                "/ajax/{controle:[a-z\$]+}", new AjaxController($Options), $nameRoute->ajax(), self::NameModule
//        );


        $router->addRoute_get(
                "/files/{controle:[a-z0-9\_\$\-]+}", new FileController($Options), $nameRoute->files(), self::NameModule
        );
    }

    protected function generateUriMenu(string $name_route, array $Controllers): array {
        $generateUriMenu = [];
        foreach ($Controllers as $controle) {
            if (is_array($controle)) {
                $controle = array_keys($controle)[0];
            }
            $url = $this->getRouter()->generateUri($name_route, ["controle" => $controle]);
            $label = ucfirst(str_replace("$", "  ", $controle));
            $generateUriMenu[$label] = $url;
        }
        return $generateUriMenu;
    }

    public function getMenu(): array {
        $menu = [
            "nav_title" => $this::NameModule,
            "nav_icon" => $this::IconModule,
            "nav" => $this->generateUriMenu($this->getNamesRoute()->show(), $this->getControllers())
                ]
        ;

        return $menu;
        // // "group"=> [[lable,url],....]
    }

}
