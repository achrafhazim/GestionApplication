<?php

namespace Kernel\Model\Entitys;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Tools\Tools;

class EntitysSchema implements MODE_SELECT_Interface
{

    private $modeCHILDREN = null;
    private $NameTable = null;
    private $COLUMNS_META = [];
    private $COLUMNS_default = ["*"];
    private $COLUMNS_master = ["*"];
    private $COLUMNS_all = ["*"];
    private $FOREIGN_KEY = [];
    private $FILES = [];
    private $STATISTIQUE = [];
    private $CHILDREN = [];

    public function Instance(array $table): self
    {
        $this->NameTable = $table["NameTable"];
        $this->COLUMNS_default = $table["COLUMNS_default"];
        $this->COLUMNS_master = $table["COLUMNS_master"];
        $this->COLUMNS_all = $table["COLUMNS_all"];
        $this->COLUMNS_META = $table["COLUMNS_META"];
        $this->FOREIGN_KEY = $table["FOREIGN_KEY"];
        $this->FILES = $table["FILES"];
        $this->STATISTIQUE = $table["STATISTIQUE"];
        $this->CHILDREN = $table["CHILDREN"];

        return $this;
    }

    /*
     * modeCHILDREN
     */

    private function setModeCHILDREN($mode)
    {
        if ($mode == null and $this->modeCHILDREN == null) {
            $this->modeCHILDREN = self::_MASTER;
        } elseif ($mode != null) {
            $this->modeCHILDREN = $mode;
        }
    }

    /*
     * NameTable
     */

    function getNameTable()
    {
        return $this->NameTable;
    }

    function setNameTable($NameTable)
    {
        $this->NameTable = $NameTable;
    }

    /**
     *
     * COLUMNS
     */
    /// get columns meta total ou par type exemple  getCOLUMNS_META(["Key" =>"MUL"])
    function getCOLUMNS_META(array $key = [], array $notkey = []): array
    {
        if (empty($key)) {
            return $this->COLUMNS_META;
        } else {
            if (Tools::isAssoc($key)) {
                $COLUMNS_META = Tools::entitys_TO_array($this->COLUMNS_META);

                /// condition true
                $COLUMNS_META_true = [];
                foreach ($key as $k => $v) {
                    foreach ($COLUMNS_META as $COLUMNS) {
                        if ($COLUMNS[$k] == $v) {
                            $COLUMNS_META_true[] = $COLUMNS;
                        }
                    }
                }
                $COLUMNS_META_filter = $COLUMNS_META_true;

                if (!empty($notkey)) {
                    /// condition false
                 
                    $COLUMNS_META_false = [];
                    foreach ($notkey as $k => $v) {
                        foreach ($COLUMNS_META_true as $COLUMNS) {
                            if (isset($COLUMNS[$k])) {
                                if (!in_array($COLUMNS[$k], $v)) {
                                    $COLUMNS_META_false[] = $COLUMNS;
                                }
                            } else {
                                $COLUMNS_META_false[] = $COLUMNS;
                            }
                        }
                    }
                    $COLUMNS_META_filter = $COLUMNS_META_false;
                }


                return $COLUMNS_META_filter;
            } else {
                return [];
            }
        }
    }

    function setCOLUMNS_META($COLUMNS_META)
    {
        $this->COLUMNS_META = $COLUMNS_META;
    }

    function getCOLUMNS_default()
    {
        return $this->COLUMNS_default;
    }

    function setCOLUMNS_default($COLUMNS_default)
    {
        $this->COLUMNS_default = $COLUMNS_default;
    }

    function getCOLUMNS_all()
    {
        return $this->COLUMNS_all;
    }

    function setCOLUMNS_all($COLUMNS_all)
    {
        $this->COLUMNS_all = $COLUMNS_all;
    }

    function getCOLUMNS_master()
    {
        return $this->COLUMNS_master;
    }

    function setCOLUMNS_master($COLUMNS)
    {
        $this->COLUMNS_master = $COLUMNS;
    }

    /**
     *
     * FOREIGN_KEY
     */
    function getFOREIGN_KEY()
    {
        return $this->FOREIGN_KEY;
    }

    function setFOREIGN_KEY($FOREIGN_KEY)
    {
        $this->FOREIGN_KEY = $FOREIGN_KEY;
    }

    function getFILES()
    {
        return $this->FILES;
    }

    function setFILES($FILES)
    {
        $this->FILES = $FILES;
    }

    function getSTATISTIQUE()
    {
        return $this->STATISTIQUE;
    }

    function setSTATISTIQUE($STATISTIQUE)
    {
        $this->STATISTIQUE = $STATISTIQUE;
    }

    /*
     * CHILDREN
     */

    function getCHILDREN($mode = null)
    {
        $this->setModeCHILDREN($mode);

        return $this->CHILDREN[$this->modeCHILDREN];
    }

    function get_table_CHILDREN($mode = null)
    {
        $this->setModeCHILDREN($mode);
        $TABLE = [];
        foreach ($this->CHILDREN[$this->modeCHILDREN] as $table => $columns) {
            $TABLE[] = $table;
        }

        return $TABLE;
    }

    function setCHILDREN($CHILDREN)
    {

        $this->CHILDREN = $CHILDREN;
    }

///TOULS
    /*
     * SELECT SQL
     */

    public function select_default()
    {

        $select = [];
        foreach ($this->COLUMNS_default as $colom) {
            $select[] = $this->NameTable . "." . $colom;
        }
//        foreach ($this->FOREIGN_KEY as $FOREIGN) {
//            $select[] = $FOREIGN . "." . $FOREIGN;
//        }
        return $select;
    }

    public function select_master()
    {

        $select = [];
        foreach ($this->COLUMNS_master as $colom) {
            $select[] = $this->NameTable . "." . $colom;
        }
//        foreach ($this->FOREIGN_KEY as $FOREIGN) {
//            $select[] = $FOREIGN . "." . $FOREIGN;
//        }
        return $select;
    }

    public function select_all()
    {

        $select = [];
        foreach ($this->COLUMNS_all as $colom) {
            $select[] = $this->NameTable . "." . $colom;
        }
//        foreach ($this->FOREIGN_KEY as $FOREIGN) {
//            $select[] = $FOREIGN . "." . $FOREIGN;
//        }
        return $select;
    }

    public function select_NameTable()
    {

        $select = [];
        foreach ($this->COLUMNS_master as $colom) {
            $select[] = $this->NameTable . "." . $colom;
        }

        return $select;
    }

    public function select_FOREIGN_KEY(array $FOREIGN_KEY = [])
    {
        $select = [];
        if (empty($FOREIGN_KEY)) {
            $FOREIGN_KEY = $this->FOREIGN_KEY;
        }
        foreach ($FOREIGN_KEY as $FOREIGN) {
            $select[] = $FOREIGN . "." . $FOREIGN;
        }



        return $select;
    }

    public function select_CHILDREN($TABLE = null, $mode = null)
    {
        $this->setModeCHILDREN($mode);
        $select = [];

        if ($TABLE == null) {
            foreach ($this->CHILDREN[$this->modeCHILDREN] as $table => $colums) {
                foreach ($colums as $colum) {
                    $select[] = $table . "." . $colum . " as $table" . "_" . $colum;
                }
            }
        } else {
            foreach ($this->CHILDREN[$this->modeCHILDREN][$TABLE] as $colum) {
                $select[] = $TABLE . "." . $colum . " as $TABLE" . "_" . $colum;
            }
        }




        return $select;
    }

//    ////
//       public function select_statistique_SUM(): array {
//
//        $select = [];
//        $FOREIGN_KEY = [];
//
//        foreach ($this->STATISTIQUE as $colom) {
//
//            $select[] = "SUM(" . $this->NameTable . "." . $colom . ") as  ` $colom des " . str_replace("$", " suite aux ", $this->NameTable) . " ` ";
//        }
//
//        foreach ($this->FOREIGN_KEY as $FOREIGN) {
//            $FOREIGN_KEY[] = $FOREIGN;
//        }
//
//        return ["table" => $this->NameTable,
//            "select" => $select,
//            "FOREIGN_KEY" => $FOREIGN_KEY];
//    }

    public function select_statistique($fonction, $alias): array
    {

        $select = [];
        $FOREIGN_KEY = [];

        foreach ($this->STATISTIQUE as $colom) {
            $select[] = "$fonction( $this->NameTable.$colom ) as  `" . "$colom " . "$alias" . "`";
        }

        foreach ($this->FOREIGN_KEY as $FOREIGN) {
            $FOREIGN_KEY[] = $FOREIGN;
        }

        return ["table" => $this->NameTable,
            "select" => $select,
            "FOREIGN_KEY" => $FOREIGN_KEY];
    }
}
