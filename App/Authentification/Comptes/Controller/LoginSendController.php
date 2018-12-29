<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification\Comptes\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use App\AbstractModules\Controller\AbstractController;
use App\Authentification\AutorisationInterface;
use App\Authentification\Comptes\Model\Model;
use Kernel\AWA_Interface\PasswordInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginSendController extends AbstractController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        parent::process($request, $handler);
        $password = false;
        $login = false;
        $post = $request->getParsedBody();
        if (isset($post["login"]) && isset($post["password"])) {
            $login = $post["login"];
            $password = $post["password"];
            $session = $this->getSession();
            $response = $this->getResponse();
            $key = AutorisationInterface::Auth_Session;
            $this->setModel(new Model($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
            $model = $this->getModel("comptes");
            $compte = $model->login($login);
            
            
            /**
             * get compte and set to session
             */
            if (!empty($compte)) {
                $p = $this->getContainer()->get(PasswordInterface::class);
                $password_encrypt = $compte["password"];

                if ($p->verify($password, $password_encrypt)) {
                    $autorisation = $model->autorisation($compte, $this->getNamesControllers());
                   
                    $autorisation["comptes"] = $compte;
                    $session->set($key, $autorisation);
                }
            } else {
                $session->delete($key);
            }
        }










        if ($session->has($key)) {
            /**
             *get  url stop
             */
            $url=$session->get("url", "/");
            return $response->withHeader("Location", $url)->withStatus(301);
        } else {
            $url = $this->getRouter()->generateUri("login");

            return $response->withHeader("Location", $url)->withStatus(403);
        }
    }
}
