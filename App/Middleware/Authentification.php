<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use App\Authentification\AutorisationInterface;
use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function preg_match;

/**
 * Description of Authentification
 *
 * @author wassime
 */
class Authentification implements MiddlewareInterface, AutorisationInterface
{

    private $container;
    private $router;
    private $Response;
    private $Session;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $container->get(RouterInterface::class);
        $this->Response = $container->get(ResponseInterface::class);
        $this->Session = $container->get(SessionInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
  /////==>
        return $handler->handle($request);
   ////////////
        $route = $this->getRouter()->match($request);
        return $handler->handle($request);

// not is in modules
// get page not found
        if (!$route->isSuccess()) {
            return $handler->handle($request);
        }
//  is in login page
// url is urllogin
        $url = $request->getUri()->getPath();
        $url_login = $this->getRouter()->generateUri("login");
        if ($url == $url_login) {
            return $handler->handle($request);
        }


//is_autorise
        if ($this->is_autorise($request)) {
//ok
            return $handler->handle($request);
        } else {
            $session = $this->getSession();

            $session->set("url", $url);
//  Redirection  to ligin page


            return $this->getResponse()
                            ->withHeader("Location", $url_login)
                            ->withStatus(403);
        }
    }

    protected function is_autorise($request): bool
    {
        $session = $this->getSession();
        if (!$session->has(self::Auth_Session)) {
            return false;
        }
 //get permession to table
        $Autorisation = $session->get(self::Auth_Session);
        if ($this->is_root($Autorisation)) {
            return true;
        }

        $nameModule = $this->parseNameModule($request);
        $nameControler = $this->parseNameControler($request);
        $nameRoute = $this->NameRoute($request);
        $action = $this->parseAction($request);
        $nameTableAutorisation = self::Prefixe . $nameModule;
        if (isset($Autorisation[$nameTableAutorisation])) {
            $TableAutorisation = $Autorisation[$nameTableAutorisation];
            var_dump($TableAutorisation);
            die();
            foreach ($TableAutorisation as $row) {
                if ($row['controller'] == $nameControler || preg_match("/^" . $row['controller'] . "/i", $nameControler)) {

                    /**
                     * show
                     */
                    if ($row[$action->name_show()] == "1") {
                        if ($nameRoute->is_show() || $nameRoute->is_ajax()) {
                            if ($action->is_index() || $action->is_show()) {
                                return true;
                            }
                        }
                        if ($nameRoute->is_files()) {
                            return true;
                        }
                    }
                    /**
                     * add
                     */
                    if ($row[$action->name_add()] == "1") {
                        if ($nameRoute->is_send() || $nameRoute->is_show()) {
                            if ($action->is_add() || $action->is_show()) {
                                return true;
                            }
                        }
                        if ($nameRoute->is_files()) {
                            return true;
                        }
                    }
                    /**
                     * update
                     */
                    if ($row[$action->name_update()] == "1") {
                        if ($nameRoute->is_send() || $nameRoute->is_show()) {
                            if ($action->is_update() || $action->is_show()) {
                                return true;
                            }
                        }
                        if ($nameRoute->is_files()) {
                            return true;
                        }
                    }
                    /**
                     * delete
                     */
                    if ($row[$action->name_delete()] == "1") {
                        if ($nameRoute->is_show()) {
                            if ($action->is_delete() || $action->is_message() || $action->is_show()) {
                                return true;
                            }
                        }
                        if ($nameRoute->is_files()) {
                            return true;
                        }
                    }
                }
            }
            return false;
        } else {
            return false;
        }
    }

    protected function is_root($Autorisation): bool
    {
        return $Autorisation["comptes"]["id"] === "1" && $Autorisation["comptes"]["active"] === "1";
    }

    protected function parseNameModule(ServerRequestInterface $request): string
    {
        $url = $request->getUri()->getPath();
        preg_match('!/([A-Za-z]+)(.*)!i', $url, $matches);
        if (empty($matches)) {
            return "";
        } else {
            return $matches[1];
        }
    }

    protected function NameRoute(ServerRequestInterface $request): NamesRouteInterface
    {
        $route = $this->getRouter()->match($request);
        $name = $route->getName();
        $nameRoute = $this->container->get(NamesRouteInterface::class);
        $nameRoute->set_NameRoute($name);
        return $nameRoute;
    }

    protected function parseNameControler(ServerRequestInterface $request): string
    {
        $route = $this->getRouter()->match($request);
        return $route->getParam("controle");
    }

    protected function parseAction(ServerRequestInterface $request): ActionInterface
    {
        $route = $this->getRouter()->match($request);
        $urlaction = $route->getParam("action");
        $action = $this->container->get(ActionInterface::class);
        $action->setAction($urlaction);
        return $action;
    }

    protected function getRouter(): RouterInterface
    {
        return $this->router;
    }

    protected function getResponse(): ResponseInterface
    {
        return $this->Response;
    }

    protected function getSession(): SessionInterface
    {
        return $this->Session;
    }
}
