<?php

/*BaliseOrpheline
  <br> : retour à la ligne dans un paragraphe principalement.

  <hr> : un trait horizontal

  <input> : un élément de formulaire (balise <form>)

  <area> : pour délimiter une zone dans une imagemap

  <meta> : balise de métadonnées inséré dans le <head>

  <img> : balise pour mettre une image

  <link> : pour mettre un lien vers un fichier, css ou js.

  <param> : permet de définir des paramètres dans une balise <object>
 */

namespace Kernel\html;

/**
 * Description of HTML
 *
 * @author wassime
 */
class HTML
{

    private $tag = "";
    private $BaliseOrpheline = ["br", "hr", "input", "area", "meta", "img", "link", "param"];
    private $html = [];
    private $data = "";
    private $att = "";

    public static function TAG(string $tag): self
    {
        return new self($tag);
    }

    function __construct(string $tag = "")
    {
        $this->setTag($tag);
    }

    function builder(): string
    {
        $params = "";
        foreach ($this->html as $param => $value) {
            $params .= $param . ' = "' . $value . '"   ';
        }
        $params .= $this->att;

        if (in_array($this->tag, $this->BaliseOrpheline)) {
            $builder = "<$this->tag $params>";
        } else {
            $builder = "<$this->tag $params>$this->data</$this->tag>";
        }
        
        return $builder;
    }

    function setTag(string $tag): self
    {
        $this->tag = strtolower($tag);
        return $this;
    }

    function setAtt($att): self
    {
        if (is_string($att)) {
            $this->att =$this->att. $att;
        }
        return $this;
    }

    function setData($data): self
    {
        if ($data !=null) {
            if (is_string($data)) {
                $this->data = $data;
            }if (is_array($data)) {
                $this->data = implode(" ", $data);
            }
        }
        
        return $this;
    }

    /////////////////////////////////////////////////////////////////////

    function setType(string $type): self
    {

        $this->html['type'] = trim($type);
        return $this;
    }

    function setFor(string $For): self
    {

        $this->html['for'] = trim($For);
        return $this;
    }

    function setClass(string $class): self
    {
        $this->html['class'] = trim($class);
        return $this;
    }

    function setId(string $id): self
    {
        $this->html['id'] = trim($id);
        return $this;
    }
    function setName(string $name): self
    {
        $this->html['name'] = trim($name);
        return $this;
    }

    function setPlaceholder(string $placeholder): self
    {
        $this->html['placeholder'] = trim($placeholder);
        return $this;
    }

    function setValue($value = null): self
    {
        if ($value != null) {
            $this->html['value'] = trim($value);
        }
        return $this;
    }
    ///////////////////////////////////////////////////////////////////
}
