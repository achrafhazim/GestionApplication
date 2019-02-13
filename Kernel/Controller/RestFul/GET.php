<?php

//display
//JSON
//   affiche liset      methode get        /api/controle            variable GET
//                                         /api/controle/id=:id    variable GET
//                                         /api/controle?......    variable GET
//                                         /api/controle?by=id|date&op=pe|be&p1=44&p2=2/9/2012|2/9/2017&limit=10    variable GET


/*
 * by    filde_where default id
  params :/id  or :p :p1 :p2 .....
 * Opérateur op default = Égale

  =	            |  e       |  Égale
  !=	        |  pe      |  Pas égale
  >	            |  s       |  Supérieur à
  <	            |  i       |  Inférieur à
  >=	        |  se      |  Supérieur ou égale à
  <=	        |  ie      |  Inférieur ou égale à
  IN	        |  in      |  Liste de plusieurs valeurs possibles
  BETWEEN	    |  be      |  Valeur comprise dans un intervalle donnée (utile pour les nombres ou dates)
  LIKE	        |  li      |  Recherche en spécifiant le début, milieu ou fin d'un mot.
  IS NULL	    |  nu      |  Valeur est nulle
  IS NOT NULL	|  notnu   |  Valeur n'est pas nulle



 * ModeSelect
  - s_p default MODE_SELECT_Interface::_DEFAULT
  - s_f default MODE_SELECT_Interface::_NULL




 * **** raport
 * GROUP BY  HAVING
 * ****Fonctions d’agrégation SQL
  -AVG() pour calculer la moyenne sur un ensemble d’enregistrement
  -COUNT() pour compter le nombre d’enregistrement sur une table ou une colonne distincte
  -MAX() pour récupérer la valeur maximum d’une colonne sur un ensemble de ligne. Cela s’applique à la fois pour des données numériques ou alphanumérique
  -MIN() pour récupérer la valeur minimum de la même manière que MAX()
  -SUM() pour calculer la somme sur un ensemble d’enregistrement
 * *****
 * 
 * 
 * 
 */

namespace Kernel\Controller\RestFul;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Tools\Tools;
use Kernel\ToolsView\INTENT\Intent_JS;

/**
 * Description of GETcontroller
 *
 * @author wassime
 */
class GET {

    private $Container;
    private $model;

    function __construct($Container, $model) {
        $this->Container = $Container;
        $this->model = $model;
    }

    public function run(int $id = 0, array $GET = []) {
        if (isset($GET["schema"])) {
         return   $this->schema();
        }

        $query = $this->query($id, $GET);
        $ModeSelect = $this->ModeSelect($GET);

        $entity = $this->model->find($query, $ModeSelect);
        $data = Tools::entitys_TO_array($entity);

        return $data;
    }

    function schema() {
        $schema = $this->model->getschema();



        $intent_js= new Intent_JS();
        $META_data = $schema->getCOLUMNS_META();

        $intent_js->setCOLUMNS_META($META_data);
       

        return $intent_js->getJson_Schema_Input();
      
        
    }

    protected function query($id = null, $GET = []) {


        if ($id == null) {
            return $this->query_GET($GET);
        } else {
            return $this->query_id($id);
        }
    }

    protected function ModeSelect(array $GET): array {

        $parent = MODE_SELECT_Interface::_DEFAULT;
        $child = MODE_SELECT_Interface::_NULL;


        if (isset($GET["s_p"])) {
            $parent = $this->parseMode($GET["s_p"], $parent);
        }
        if (isset($GET["s_f"])) {
            $child = $this->parseMode($GET["s_f"], $child);
            if ($child != MODE_SELECT_Interface::_NULL) {
                
            }
        }


        return [$parent, $child];
    }

///**********************************************************************************/////

    private function parseMode(string $modefr, $default): string {
        switch ($modefr) {
            case "0":
                $mode = MODE_SELECT_Interface::_NULL;
                break;
            case "1":
                $mode = MODE_SELECT_Interface::_MASTER;
                break;
            case "2":
                $mode = MODE_SELECT_Interface::_DEFAULT;
                break;
            case "*":
                $mode = MODE_SELECT_Interface::_ALL;
                break;

            default:
                $mode = $default;
                break;
        }
        return $mode;
    }

    //////////////////////////////////////////////////////////////////////////////////////

    /**
     * parst query par URL
     * @param type $id
     * @return array
     */
    private function query_id($id): array {
        return ["id" => $id];
    }

    /**
     * parst query par methode GET
     * @param type $GET
     * @return array
     */
    private function query_GET($GET): array {
        $by = $this->by($GET);
        $q = [];
        foreach ($by as $index => $champ) {
            $op = $this->operateur($GET, $index);
            $params_index = $this->params($GET, $index);

            if ($op === "IS NULL" || $op === "IS NOT NULL") {
                $q[] = $champ . "  " . $op . "  ";
            } elseif ($op === "BETWEEN" && !empty($params_index)) {

                $param = implode(" AND ", $params_index);
                $q[] = $champ . "  " . $op . "  " . $param;
            } elseif ($op === "IN" && !empty($params_index)) {

                $param = implode(" , ", $params_index);
                $q[] = $champ . "  " . $op . "  ( " . $param . " ) ";
            } elseif (!empty($params_index)) {

                $param = $params_index[0];
                $q[] = $champ . "  " . $op . " '" . $param . "' ";
            } else {
                $q[] = " 1 ";
            }
        }

        return $q;
    }

    /**
     * 
     * @param array $GET
     * @return array
     */
    private function by(array $GET): array {
        if (isset($GET["by"])) {
            return explode('|', $GET["by"]);
        }
        return ["id"];
    }

    //params :/id  or ?:p0 ?:p1 ?:p2 .....
    private function params(array $GET, int $index = -1): array {
        $params = [];

        foreach ($GET as $key => $value) {
            if (preg_match('/^p[0-9]+/i', $key)) {

                $params[] = explode('|', $value);
            }
        }

        if ($index == -1) {
            return $params;
        } elseif (isset($params[$index])) {
            return $params[$index];
        } else {
            return [];
        }
    }

    /**
     * 
     * @param array $GET
     * @return array|string
     */
    private function operateur(array $GET, int $index) {
        /* Opérateur op default = Égale

          =	            |  e       |  Égale
          !=	        |  pe      |  Pas égale
          >	            |  s       |  Supérieur à
          <	            |  i       |  Inférieur à
          >=	        |  se      |  Supérieur ou égale à
          <=	        |  ie      |  Inférieur ou égale à
          IN	        |  in      |  Liste de plusieurs valeurs possibles
          BETWEEN	    |  be      |  Valeur comprise dans un intervalle donnée (utile pour les nombres ou dates)
          LIKE	        |  li      |  Recherche en spécifiant le début, milieu ou fin d'un mot.
          IS NULL	    |  nu      |  Valeur est nulle
          IS NOT NULL	|  notnu   |  Valeur n'est pas nulle
         * 
         */

        if (isset($GET["op"])) {
            $operateurs = [];
            $ops = explode('|', $GET["op"]);
            foreach ($ops as $op) {

                switch ($op) {
                    case "e":
                        $operateurs[] = "=";
                        break;
                    case "pe":
                        $operateurs[] = "!=";
                        break;
                    case "s":
                        $operateurs[] = ">";
                        break;
                    case "i":
                        $operateurs[] = "<";
                        break;
                    case "se":
                        $operateurs[] = ">=";
                        break;
                    case "ie":
                        $operateurs[] = "<=";
                        break;
                    case "in":
                        $operateurs[] = "IN";
                        break;
                    case "be":
                        $operateurs[] = "BETWEEN";
                        break;
                    case "li":
                        $operateurs[] = "LIKE";
                        break;
                    case "nu":
                        $operateurs[] = "IS NULL";
                        break;
                    case "notnu":
                        $operateurs[] = "IS NOT NULL";
                        break;
                    default:
                        $operateurs[] = "=";
                        break;
                }
            }

            if ($index == -1) {
                return $operateurs;
            } elseif (isset($operateurs[$index])) {
                return $operateurs[$index];
            } else {
                return "=";
            }
        }
        return "=";
    }

}
