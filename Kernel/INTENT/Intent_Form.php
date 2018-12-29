<?php

/*
  object set
 */

namespace Kernel\INTENT;

use Kernel\Conevert\SQL_HTML;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Tools\Tools;
use function array_keys;
use function array_merge;

/**
 * Description of Intent_Form
 *
 * @author wassime
 */
class Intent_Form
{

    /**
     *
     * @var array schema table sql
     */
    private $COLUMNS_META = [];

    /**
     *
     * @var array data loade select
     */
    private $data_loade_select = [];

    /**
     *
     * @var array data loade multi select => table Relation
     */
    private $data_loade_MULselect = [];

    /**
     *
     * @var array data save pour =>update
     */
    private $data_default = [];

    /**
     * data relation pour chaque item
     * @var array data liet (tablerelation) save pour =>update
     */
    private $data_default_JOIN = [];

    /**
     * init form html or view data save
     * @return array Schema_input
     */
    public function getInputsSchema(): array
    {
        $inputSTD = $this->inputs_MUL();
        $inputMUL = $this->inputs_STD();

        return array_merge($inputSTD, $inputMUL);
    }

///////////////////////////////////////////////////////////////////

    /**
     * schema table sql type array object entity
     * @param array $COLUMNS_META
     */
    function setCOLUMNS_META(array $COLUMNS_META)
    {
        $this->COLUMNS_META = Tools::entitys_TO_array($COLUMNS_META);
    }

    /**
     * entitys_TO_array data_select
     * @param array $Charge_data_select =>object entity
     */
    function setCharge_data_select(array $Charge_data_select)
    {
        $data = Tools::entitys_TO_array($Charge_data_select);
        $this->data_loade_select = $data;
    }

    /**
     * data multiselect data relation
     * @param array $Charge_data_multiSelect =>object entity
     */
    function setCharge_data_multiSelect(array $Charge_data_multiSelect)
    {

        $data = $this->delete_prefix($Charge_data_multiSelect);

        $this->data_loade_MULselect = $data;
    }

    /**
     * data save etat => update
     * data entity sava
     * data relation lier =>par etim
     * @param EntitysDataTable $Default_Data
     */
    function setDefault_Data(EntitysDataTable $Default_Data)
    {

        $DefaultData = Tools::entitys_TO_array($Default_Data);
        $DataJOIN = $this->delete_prefix($Default_Data->getDataJOIN());

        $this->data_default = $DefaultData;
        $this->data_default_JOIN = $DataJOIN;
    }

    /*     * ********************************* */

    /**
     *
     * @param string $key
     * @return type
     */
    private function getData_loade_select(string $key = "")
    {
        if ($key != "") {
            if (isset($this->data_loade_select[$key])) {
                return $this->data_loade_select[$key];
            } else {
                return [];
            }
        }
        return $this->data_loade_select;
    }

    /**
     *
     * @param string $key
     * @return type
     */
    private function getData_loade_MULselect(string $key = "")
    {
        if ($key != "") {
            if (isset($this->data_loade_MULselect[$key])) {
                return $this->data_loade_MULselect[$key];
            } else {
                return [];
            }
        }
        return $this->data_loade_MULselect;
    }

    /**
     *
     * @param string $key
     * @return type
     */
    private function getData_default_JOIN(string $key = "")
    {
        if ($key != "") {
            if (isset($this->data_default_JOIN[$key])) {
                return $this->data_default_JOIN[$key];
            } else {
                return [];
            }
        }
        return $this->data_default_JOIN;
    }

    /**
     *
     * @param string $key
     * @return type
     */
    private function getData_default(string $key = "")
    {
        if ($key != "") {
            if (isset($this->data_default[$key])) {
                return $this->data_default[$key];
            } else {
                return [];
            }
        }
        return $this->data_default;
    }

    ///////////////////////////////////////////////////////////
    /**
     * remove prefix and change object entity to array
     * 'clients' =>
      [

      public 'clients_id' => string '206'
      public 'clients_clients' => string 'achrafh hazime'
      public 'clients_cin' => string 'AZ'
      ]
     * *
     *
     * to
      'clients' =>
      array [

      'id' => string '206'
      'clients' => string 'achrafh hazime'
      'cin' => string 'AZ'
      ]
     *
     *
     * @param array $Default_Data
     * @return array
     */
    private function delete_prefix(array $Default_Data): array
    {

        $Default_DataArray = [];

        foreach ($Default_Data as $nameTable => $dataTable) {
            foreach ($dataTable as $Entiti_data) {
                $Default_DataArray[$nameTable][] = (Tools::entitys_TO_array($Entiti_data, $nameTable));
            }
        }
        return $Default_DataArray;
    }

    /**
     * schema input type , default ,isnull .....
     * @return array Schema_Input_HTML
     */
    private function getArray_Schema_Input(): array
    {


        $Array_Schema_Input = [];
        foreach ($this->COLUMNS_META as $COLUMN_META) {
            $schema_Input_HTML = (new Schema_Input_HTML())->
                    setName($COLUMN_META['Field'])->
                    setType(SQL_HTML::getTypeHTML($COLUMN_META['Type']))
                    ->setIsNull($COLUMN_META['Null'])
                    ->setDefault($COLUMN_META['Default'])
                    ->setSefix("id_html_");
            $Array_Schema_Input[$schema_Input_HTML->getName()] = $schema_Input_HTML;
        }
        return $Array_Schema_Input;
    }

    ////////////////////////////////////////////////////////////////

    /**
     * input standard
     * @return array Schema_Input_HTML
     */
    private function inputs_STD(): array
    {

        $inputSTD = [];
        $schema_Input = $this->getArray_Schema_Input();
        // return  $schema_Input;

        /**
         * charge data select
         * charge date save pour etat update
         */
        foreach ($schema_Input as $name => $schema_Input_HTML) {
            // set data on select input <option> ......
            $dataSele = $this->getData_loade_select($name);
            $schema_Input_HTML->setData_load($dataSele);
            // set data si  is save  => etat update
            $dataDef = $this->getData_default($name);
            $schema_Input_HTML->setDefault($dataDef);

            $inputSTD[$name] = $schema_Input_HTML;
        }

        return $inputSTD;
    }

    /**
     * inpyt type multiSelect
     * get data table relation lier pour créer input multi select
     * @return array Schema_Input_HTML
     */
    private function inputs_MUL(): array
    {

        $inputMUL = [];

        // get names input multiselect
        $names = array_keys(
            array_merge(
                $this->getData_loade_MULselect(), //
                $this->getData_default_JOIN() //
            )
        );
        foreach ($names as $name) {
            /**
             * lier save etat update
             */
            $default = $this->getData_default_JOIN($name);
            /**
             * charge data disponible
             */
            $data_load = $this->getData_loade_MULselect($name);

            /**
             * creer schem input and setdata type
             */
            $inputMUL[$name] = (new Schema_Input_HTML())
                    ->setName($name)
                    ->setType("mult_select")
                    ->setDefault($default)
                    ->setData_load($data_load);
        }
        return $inputMUL;
    }
}
