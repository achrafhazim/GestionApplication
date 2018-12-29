<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

/**
 * Description of Schema_Input_HTML
 *
 * @author wassime
 */
class Schema_Input_HTML
{

    /**
     * name Field
     * @var string
     */
    private $name;
    /*
     * converte sql html
     * type input html
     */
    private $type;

    /**
     * is set null to data base
     * @var boll
     */
    private $isNull = true;

    /**
     * valure default en dataBase
     * @var string
     */
    private $default = "";

    /**
     * sefix #id
     * #id element html
     * @var string
     */
    private $sefix = "id_html_";

    /**
     * data charge select input
     * @var array
     */
    private $data_load = [];

    function getData_load(): array
    {
        return $this->data_load;
    }

    function setData_load(array $data_load): self
    {
        $this->data_load = $data_load;
        return $this;
    }

    /**
     * #id element html exemple id_html_nom
     * @return string
     */
    function getId_html(): string
    {
        // java scripe ==> not $ in id html
        $name = (str_replace(["$"], "_", $this->getName()));
        return $this->sefix . $name;
    }

    /**
     *
     * @return string
     */
    function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    function getType(): string
    {
        // html Renvoie une chaîne en minuscules
        return strtolower($this->type);
    }

    /**
     *
     * @return string NO | YES
     */
    function getIsNull()
    {
        if ($this->isNull) {
            return "YES";
        } else {
            return "NO";
        }
    }

    /**
     *
     * @return string|array
     */
    function getDefault()
    {
        return $this->default;
    }

    /**
     *
     * @param string $name
     * @return \self
     */
    function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param string $type
     * @return \self
     */
    function setType(string$type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @param bool $isNull
     * @return \self
     */
    function setIsNull($isNull): self
    {
        if (is_string($isNull) && $isNull === "NO") {
            $this->isNull = false;
        } elseif (is_bool($isNull)) {
            $this->isNull = $isNull;
        }
        return $this;
    }

    /**
     *
     * @param string|array $default
     * @return \self
     */
    function setDefault($default): self
    {

        $this->default = $default;

        return $this;
    }

    /**
     *
     * @param string $sefix
     * @return \self
     */
    function setSefix(string $sefix): self
    {
        $this->sefix = $sefix;
        return $this;
    }
}
