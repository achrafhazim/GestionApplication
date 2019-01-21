<?php

namespace Kernel\Controller;

use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\ModelInterface;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\AWA_Interface\RouteInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\SessionInterface;
use Kernel\Tools\Tools;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function in_array;
use function is_a;
use function preg_match;
use function ucfirst;

abstract class Controller implements MiddlewareInterface {

    private $erreur = [];
    private $action = [];
    private $container;
    private $model = null;
    private $File_Upload;
    private $router;
    private $route;
    private $request;
    private $response;
    private $middlewares = [];
    private $nameController = "";
    private $namesControllers = [];
    private $child = [];
    private $notSelect = [];
    private $nameModule;
    private $namesRoute;

    function __construct(array $Options) {
        $Controllers = $Options["namesControllers"];
        $this->chargeControllers($Controllers);

        $this->container = $Options["container"];


        $this->nameModule = $Options["nameModule"];
        $this->setMiddlewares($Options["middlewares"]);
        $this->namesRoute = $Options["nameRoute"];


        $this->action = $this->getContainer()->get(ActionInterface::class);

        $this->namesRoute->set_NameModule($this->nameModule);
        $this->erreur["Controller"] = false;
        $this->erreur["Model"] = false;

        $this->setRouter($this->getContainer()->get(RouterInterface::class));

        $this->setFile_Upload($this->getContainer()->get(File_UploadInterface::class));
    }

    function getContainer(): ContainerInterface {
        return $this->container;
    }

    //
// psr 7

    function setRequest(ServerRequestInterface $request) {
        $this->request = $request;
    }

    function setResponse(ResponseInterface $response) {
        $this->response = $response;
    }

    function getRequest(): ServerRequestInterface {
        return $this->request;
    }

    function getResponse(): ResponseInterface {
        return $this->response;
    }

    function getSession(): SessionInterface {
        return $this->getContainer()->get(SessionInterface::class);
    }

// psr 15

    function setMiddlewares(array $middlewares) {
        $this->middlewares = $middlewares;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        /**
         * add middlewares de module  to despatchre
         *
         */
        // apres
        foreach ($this->middlewares as $middleware) {
            $this->container->get(RequestHandlerInterface::class)
                    ->pipe($middleware);
        }



        $Response = $handler->handle($request);
        $this->setRequest($request);
        $this->setResponse($Response);

        $route = $this->getRouter()->match($this->getRequest());
        $this->setRoute($route);
        $namecontrole = $this->getRoute()->getParam("controle");
        $this->setNameController($namecontrole);

        return $this->getResponse();
    }

// router

    function setRouter(RouterInterface $router) {
        $this->router = $router;
    }

    function getRoute(): RouteInterface {
        return $this->route;
    }

    function setRoute(RouteInterface $route) {
        $this->route = $route;
    }

    function getRouter(): RouterInterface {
        return $this->router;
    }

    // mvc


    function is_Erreur(string $MC = ""): bool {


        if ($MC == "") {
            return $this->erreur["Controller"] || $this->erreur["Model"];
        } else {
            return $this->erreur[$MC];
        }
    }

    function Actions(): ActionInterface {
        return $this->action;
    }

    function getNameModule(): string {
        return $this->nameModule;
    }

    function getNamesRoute(): NamesRouteInterface {
        return $this->namesRoute;
    }

    /// model
    public function getClassModel(): string {
        $type = "Model";

        $modul = $this->getNameModule();
        $controller = ucfirst($this->getNameController());

        $class = "\App\Modules\\$modul\\$type\\$controller";

        if (class_exists($class)) {

            return $class;
        }

        $classDefault = "\App\Modules\\$modul\\$type\\$type";

        if (class_exists($classDefault)) {

            return $classDefault;
        }
        $classDAbstractModules = "\App\AbstractModules\\$type\\$type";

        if (class_exists($classDAbstractModules)) {

            return $classDAbstractModules;
        }

        // error
    }

    function setModel(ModelInterface $model) {
        $this->model = $model;
    }

    protected function getModel(string $nameTable = ""): ModelInterface {

        if ($this->model === null) {
            $classModel = $this->getClassModel();
            $this->setModel(new $classModel($this->getContainer()->get("pathModel"),
                            $this->getContainer()->get("tmp")));
        }

        if ($nameTable !== "") {
            $this->chargeModel($nameTable);
        } else {
            $this->chargeModel($this->getNameController());
        }

        return $this->model;
    }

    protected function hasModel(): bool {
        return is_a($this->model, ModelInterface::class);
    }

    protected function chargeModel($table): bool {
        $flag = $this->hasModel();

        if ($flag) {
            $flag = $this->model->setTable($table);
            $this->erreur["Model"] = $flag;
        }
        return $flag;
    }

    /// controller
    private function chargeControllers($Controllers) {
        foreach ($Controllers as $Controller) {
            if (is_string($Controller)) {
                $this->namesControllers [] = $Controller;
            } elseif (is_array($Controller)) {
                if (Tools::isAssoc($Controller)) {
                    $namesController = array_keys($Controller)[0];
                    $option = $Controller[$namesController];
                    if (isset($option['child'])) {
                        $this->child[$namesController] = $option['child'];
                    }
                    if (isset($option['notSelect'])) {
                        $this->notSelect[$namesController] = $option['notSelect'];
                    }
                } else {
                    $namesController = $Controller[0];
                }
                $this->namesControllers [] = $namesController;
            }
        }
    }

    protected function getChild() {

        $parent = $this->getNameController();
        if (isset($this->child[$parent])) {
            return $this->child[$parent];
        } else {
            return false;
        }
    }

    function getnotSelect(): array {
        $parent = $this->getNameController();
        if (isset($this->notSelect[$parent])) {
            return $this->notSelect[$parent];
        } else {
            return [];
        }
    }

    function getNamesControllers(): array {
        return $this->namesControllers;
    }

    function getNameController(): string {
        return $this->nameController;
    }

    function setNameController(string $nameController): bool {
        $flag = false;
        // si on namse du module
        $flag = in_array($nameController, $this->getNamesControllers());
        if ($flag) {
            $this->nameController = $nameController;
        } else {
            // si name controller file
            preg_match('/([a-zA-Z\$]+)_(.+)/i', $nameController, $matches);
            if (!empty($matches)) {
                $flag = in_array($matches[1], $this->getNamesControllers());
                if ($flag) {
                    $this->nameController = $matches[1];
                }
            }
        }
        //etat du erreur
        $this->erreur["Controller"] = !$flag;
        return $flag;
    }

    /// File_Upload


    function getFile_Upload(): File_UploadInterface {
        return $this->File_Upload;
    }

    function setFile_Upload(File_UploadInterface $File_Upload) {
        $this->File_Upload = $File_Upload;
    }

}
