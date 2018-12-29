<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer;

use Kernel\AWA_Interface\RendererInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent;
use Kernel\Tools\Tools;

/**
 * Description of TwigRenderer
 *
 * @author wassime
 */
class TwigRenderer implements RendererInterface
{

    private $twig;
    private $loader;
    static $renderer = null;

    function __construct($pathTemplete, $PathConfigJsone,$cache=false)
    {

        $this->loader = new Twig_Loader_Filesystem($pathTemplete);
        $this->twig = new Twig_Environment($this->loader, array(
            'cache' => $cache,
            
            'debug' => true,
             
        ));

        $this->twig->addFunction(new \Twig_SimpleFunction("html", function ($context) {

            return $context;
        }, ['is_safe' => ['html']]));

        $this->twig->addFunction(new \Twig_SimpleFunction("awa", function ($context, $context2) {

            return $context . "   => " . $context2;
        }, ['is_safe' => ['html']]));

        $this->twig->addExtension(new Twig_Extension\Table);
        $this->twig->addExtension(new \Twig_Extension_Debug);
        $this->twig->addExtension(new Twig_Extension\Inpute_Table);
        
        //// configue Extension
        $this->twig->addExtension(new Twig_Extension\Form($PathConfigJsone));
    }

    public static function getRenderer(string $path = "")
    {

        if (is_null(self::$renderer)) {
            self::$renderer = new self($path);
        }

        return self::$renderer;
    }

    public function addGlobal(string $key, $value)
    {
        $this->twig->addGlobal($key, $value);
        return $this;
    }

    public function addPath(string $path, string $namespace)
    {
        $this->loader->addPath($path, $namespace);
        return $this;
    }

    public function render(string $view, array $param = array()): string
    {
        return $this->twig->render("$view.twig", $param);
    }
}
