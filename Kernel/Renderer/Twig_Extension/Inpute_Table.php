<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\AWA_Interface\RouterInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class Inpute_Table extends Twig_Extension
{

    private $router;
    private $action;
    private $nameController;
    private $namesRoute;

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("input_tableHtml", [$this, "input_tableHtml"], ['is_safe' => ['html'], 'needs_context' => true]),
            new Twig_SimpleFunction("input_tableJson", [$this, "input_tableJson"], ['is_safe' => ['html'], 'needs_context' => true]),
        ];
    }

    public function input_tableJson(array $context): string
    {
        $url = $this->getUrl($context);
        $message = "urlmessage|" . $url["message"];
        $supprimer = "urlsupprimer|" . $url["supprimer"];
        $modifier = "urlmodifier|" . $url["modifier"];
        $ajouter = "urlajouter|" . $url["ajouter"];
        $voir = "urlvoir|" . $url["voir"];

        return $message . "~" . $supprimer . "~" . $modifier . "~" . $ajouter . "~" . $voir;
    }

    public function input_tableHtml(array $context): array
    {

        $url = $this->getUrl($context);
        $message = $url["message"];
        $supprimer = $url["supprimer"];
        $modifier = $url["modifier"];
        $voir = $url["voir"];


        $input = ["title" => '<i class="glyphicon glyphicon-edit  " style="color:#3665B0;display: block;margin: auto;width: 15px;"></i>',
            "body" => '<spam style="display: inline-block;    width: max-content;">'
            . '<button class="btn btn-danger   supprimer" data-urlmessage="' . $message . '"   data-urlsup="' . $supprimer . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
            . '<a class="btn btn-success  modifier"    href="' . $modifier . '" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
            . '<a class="btn btn-primary  voir"    href="' . $voir . '" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
            . '</spam>'
        ];
        return $input;
    }

    private function getUrl(array $context)
    {

        $this->set_context($context);
        $url = [];
        $nameroute = $this->getNamesRoute()->show();
        $url["supprimer"] = $this->getRouter()->generateUri($nameroute, ["controle" => $this->getNameController(),
            "action" => $this->getAction()->name_delete(),
            "id" => 0]);
        $url["modifier"] = $this->getRouter()->generateUri($nameroute, ["controle" => $this->getNameController(),
            "action" => $this->getAction()->name_update(),
            "id" => 0]);
        $url["voir"] = $this->getRouter()->generateUri($nameroute, ["controle" => $this->getNameController(),
            "action" => $this->getAction()->name_show(),
            "id" => 0]);
        $url["message"] = $this->getRouter()->generateUri($nameroute, ["controle" => $this->getNameController(),
            "action" => $this->getAction()->name_message(),
            "id" => 0]);
        $url["ajouter"] = $this->getRouter()->generateUri($nameroute, ["controle" => $this->getNameController(),
            "action" => $this->getAction()->name_add(),
            "id" => 0]);

        return $url;
    }

    private function set_context(array $context)
    {
        $this->nameController = $context["_Controller"]; // class controller
        $this->action = $context["_Action"]; // name action add || ajouter ol jadid ....
        $this->router = $context["_Router"]; // class routes
        $this->namesRoute = $context["_NamesRoute"]; // class name route std
    }

    private function getRouter(): RouterInterface
    {
        return $this->router;
    }

    private function getAction(): ActionInterface
    {
        return $this->action;
    }

    private function getNameController(): string
    {
        return $this->nameController;
    }

    function getNamesRoute(): NamesRouteInterface
    {
        return $this->namesRoute;
    }
}
