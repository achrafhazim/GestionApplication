<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Kernel\AWA_Interface\Base_Donnee\SelectInterface;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Tools\Tools;
use TypeError;
use function explode;
use function implode;
use function is_int;
use function is_string;

/**
 * Description of Select
 *
 * @author wassime
 */
class Select extends MetaDatabase implements SelectInterface
{

    /**
     * get id (exmple:<a class="btn "  role="button" href="/CRM/files/clients_2018-08-01-16-32-12"  data-regex="/clients_2018-08-01-16-32-12/" > <spam class="glyphicon glyphicon-download-alt"></spam> 6</a>)
     * set to table de file upload
     *
     * @param string $id_save
     * @return string
     */
    public function get_idfile(string $id_save): string
    {
        $schema = $this->getSchema();
        if (empty($schema->getFILES())) {
            return "";
        }
        $id = ["{$this->getTable()}.id" => $id_save];

        $Entitys = $this->prepareQuery(self::Get_QuerySQL()
                        ->select($schema->getFILES())
                        ->from($schema->getNameTable())
                        ->where($id)
                        ->prepareQuery());
        if (empty($Entitys)) {
            return " ";
        }
        $datafile = Tools::entitys_TO_array($Entitys[0]);
        return implode($datafile);
    }

    /**
     * has id return true | false
     * @param string $id
     * @return bool
     */
    public function is_id(string $id, $schema = null): bool
    {

        $entitysDataTable = $this->find_by_id($id, self::MODE_SELECT_MASTER_NULL, $schema);
        return !$entitysDataTable->is_Null();
    }

    /**
     * recherche par id
     * @param type $id
     * @param array $mode
     * @param EntitysSchema $schema
     * @return EntitysDataTable
     */
    public function find_by_id($id, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): EntitysDataTable
    {
        $Entitys = $this->select($id, $mode, $schema);

        if (isset($Entitys[0])) {
            return ($Entitys[0]);
        } else {
            $entitysDataTable = new EntitysDataTable();
            $entitysDataTable->setNull();
            return $entitysDataTable;
        }
    }

    /**
     * pour select data to table
     * @param type $id
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array
     */
    public function select($id = true, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array
    {
        if ($schema === null) {
            $schema = $this->getSchema();
        }

        if ($id !== true) {
            if (is_string($id) || is_int($id)) {
                $id = ["{$schema->getNameTable()}.id" => $id];
            }
        }

        $fields = $this->get_fields($mode, $schema);

        $sql = self::Get_QuerySQL()
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->where($id)
                ->prepareQuery();

        $Entitys = $this->prepareQuery($sql);




        return $this->get_Data_CHILDREN($Entitys, $mode, $schema);
    }

    /**
     * select donnee simple return array assoc
     * @param array $fields
     * @param type $id
     * @param EntitysSchema $schema
     * @return array assoc
     */
    public function select_simple(array $fields, $id = true, $schema = null): array
    {
        if ($schema === null) {
            $schema = $this->getSchema();
        }

        if ($id !== true) {
            if (is_string($id) || is_int($id)) {
                $id = ["{$schema->getNameTable()}.id" => $id];
            }
        }
        return $this->prepareQueryAssoc(
            self::Get_QuerySQL()
                                ->select($fields)
                                ->from($schema->getNameTable())
                                ->where($id)
            ->prepareQuery()
        );
    }

    /**
     * pour sele data in range
     * @param string|array $rangeID
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_in($rangeID, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array
    {
        if ($schema === null) {
            $schema = $this->getSchema();
        }

        $fields = $this->get_fields($mode);

        //range
        if (is_string($rangeID)) {
            $rangeID = explode(",", $rangeID);
        }


        $sql = self::Get_QuerySQL()
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereIn("{$schema->getNameTable()}.id", $rangeID)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode, $schema);
    }

    /**
     * select data BETWEEN 2 value in id

     * @param int $valeur1
     * @param int $valeur2
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_BETWEEN(int $valeur1, int $valeur2, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array
    {
        if ($schema === null) {
            $schema = $this->getSchema();
        }
        $fields = $this->get_fields($mode);

        $sql = self::Get_QuerySQL()
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereBETWEEN("{$this->getTable()}.id", $valeur1, $valeur2)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode, $schema);
    }

    /**
     * pour show or show_in parse mode get les champs|| fildes
     * @param array $mode
     * @return array
     * @throws TypeError
     */
    private function get_fields(array $mode, $schema = null): array
    {

        // mode
        if ($schema == null) {
            $schema = $this->getSchema();
        }

        if (($mode[0] === self::_MASTER)) {
            $fields = $schema->select_master();
        } elseif ($mode[0] === self::_ALL) {
            $fields = $schema->select_all();
        } elseif ($mode[0] === self::_DEFAULT) {
            $fields = $schema->select_default();
        } else {
            throw new \TypeError(" Error mode ");
        }

        return $fields;
    }

    /**
     * pour set data relation dans entity
     * @param array $Entitys
     * @param type $mode
     * @param type $schema
     * @return array
     */
    protected function get_Data_CHILDREN(array $Entitys, array $mode, $schema = null): array
    {
        if ($schema === null) {
            $schema = $this->getSchema();
        }
        if (empty($schema->get_table_CHILDREN()) || empty($mode) || $mode[1] == self::_NULL) {
            return $Entitys;
        }

        foreach ($Entitys as $Entity) {
            foreach ($schema->get_table_CHILDREN() as $tablechild) {
                $fields = $schema->select_CHILDREN($tablechild, $mode[1]);
                $nametable = $schema->getNameTable();


                $sql = $this->prepareQuery(
                    self::Get_QuerySQL()
                                ->select($fields)
                                ->column($this->getschema($tablechild)->select_FOREIGN_KEY())
                                ->from($nametable)
                                ->join($tablechild, " INNER ", true)
                                ->join($this->getschema($tablechild)->getFOREIGN_KEY(), " INNER ", false, "", $tablechild)
                                ->where($schema->getNameTable() . ".id = " . $Entity->id)
                    ->prepareQuery()
                );
                $Entity->setDataJOIN($tablechild, $sql);
            }
        }

        return $Entitys;
    }
}
