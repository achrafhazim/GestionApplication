<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Renderer
 *
 * @author wassime
 */

namespace Kernel\Renderer;

class PHPRenderer implements RendererInterface
{

    private $paths = [];
    static $renderer = null;
    private $global=[];

    const DEFAULT_NAMESPACE = "____DEFAULTRenderer___";
    private function __construct()
    {
    }

    public static function getRenderer(string $path = ""): self
    {
        if (is_null(self::$renderer)) {
            self::$renderer = new self();
        }
        if ($path!="") {
            self::$renderer->addPath($path) ;
        }
        return self::$renderer;
    }

    public function addPath(string $path, string $namespace = self::DEFAULT_NAMESPACE)
    {
        $this->paths[$namespace] = $path."/php";
        return $this;
    }

    public function render(string $view, array $param = []): string
    {


        $path = $this->generatePath($view);

        if (is_file($path)) {
            ob_start();
            extract($this->global);
            extract($param);
            $renderer = $this;
            require($path);

            return ob_get_clean();
        } else {
            die("errrrr $path");
        }
    }

    public function addGlobal(string $key, $value):self
    {
        $this->global[$key]=$value;
        return $this;
    }
    
    
    
    protected function generatePath(string $view): string
    {
        if ($view[0] === "@") {  // "@blog/demo"
            $namespace = substr($view, 1, strpos($view, '/') - 1); // blog

            $pathSave = $this->paths[$namespace];
            return (str_replace("@$namespace", $pathSave, "$view.php"));
        } else {
            return $this->paths[self::DEFAULT_NAMESPACE] . "/$view.php";
        }
    }
}
