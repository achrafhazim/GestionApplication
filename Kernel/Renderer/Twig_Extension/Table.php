<?php

namespace Kernel\Renderer\Twig_Extension;

use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent_Show;
use function array_merge;
use Kernel\Tools\Tools;
use Twig_Extension;
use Twig_SimpleFunction;

class Table extends Twig_Extension
{

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("table_intent", [$this, "table_intent"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("table_array", [$this, "table_array"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("table_json_intent", [$this, "table_json_intent"], ['is_safe' => ['html']])
        ];
    }

    private $tablehtml;

    function __construct()
    {
        $this->tablehtml = new TableHTML();
    }

    private function intent_to_metaTableHTML(Intent_Show $intent)
    {
        $schema = $intent->getEntitysSchema();
        //*****
        $entitysDataTable = $intent->getEntitysDataTable();
        //*****
        $COLUMNS_master = $schema->getCOLUMNS_master();
        $COLUMNS_all = $schema->getCOLUMNS_all();
        $COLUMNS_default = $schema->getCOLUMNS_default();
        $FOREIGN_KEY = $schema->getFOREIGN_KEY();



        if (Intent_Show::is_show_MASTER($intent)) {
            $columns = array_merge($COLUMNS_master, $FOREIGN_KEY);
        } elseif (Intent_Show::is_show_ALL($intent)) {
            $columns = array_merge($COLUMNS_all, $FOREIGN_KEY);
        } elseif (Intent_Show::is_show_DEFAULT($intent)) {
            $columns = array_merge($COLUMNS_default, $FOREIGN_KEY);
        }
        $CHILD = [];
        $CHILD["flag_show_CHILDREN"] = Intent_Show::is_get_CHILDREN($intent);

        if ($CHILD["flag_show_CHILDREN"]) {
            $CHILD["table_CHILDREN"] = $schema->get_table_CHILDREN(); // le nom de la table
            $CHILD["CHILDREN"] = $schema->getCHILDREN(); // les noms des champ
            $CHILD["datajoins"] = [];  //// body
            foreach ($entitysDataTable as $entity) {
                $CHILD["datajoins"][] = $entity->getDataJOIN();
            }

            $columns = array_merge($columns, $CHILD["table_CHILDREN"]);  ///head
        }
        
        $DataTable = Tools::entitys_TO_array($entitysDataTable);

        return [
            "columns" => $columns,
            "DataTable" => $DataTable,
            "CHILD" => $CHILD
        ];
    }

    public function table_intent(Intent_Show $intent, array $input = [])
    {



        $metaTableHTML = $this->intent_to_metaTableHTML($intent);

        $columns = $metaTableHTML["columns"];
        $DataTable = $metaTableHTML["DataTable"];
        $CHILD = $metaTableHTML["CHILD"];

        return $this->tablehtml->builder($columns, $DataTable, $CHILD, $input);
    }

    public function table_array(array $columns, array $DataTable, array $CHILD = [], array $input = [])
    {
        return $this->tablehtml->builder($columns, $DataTable, $CHILD, $input);
    }

    public function table_json_intent(Intent_Show $intent)
    {


        $entity = ($intent->getEntitysDataTable());
        $data = Tools::entitys_TO_array($entity);

        $titles = [];
        $dataSets = [];
        foreach ($data as $rom) {
            $title = [];
            $dataSet = [];
            foreach ($rom as $t => $d) {
                $title[] = ["title" => $t];
                $dataSet[] = $d;
            }
            $titles = $title;
            $dataSets[] = $dataSet;
        }

        return Tools::json(["data" => $data, "titles" => $titles, "dataSet" => $dataSets]);
    }
}
