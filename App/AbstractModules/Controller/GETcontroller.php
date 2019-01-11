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

 * LIMIT   limit      default null
 * desplayType default json
 * ModeSelect
  - champs_pere default MODE_SELECT_Interface::_DEFAULT
  - champs_fils default MODE_SELECT_Interface::_NULL




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

namespace App\AbstractModules\Controller;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Tools\Tools;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of GETcontroller
 *
 * @author wassime
 */
class GETcontroller extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
        $id = (int) $this->getRoute()->getParam("id");



        $classModel = $this->getClassModel();
        $this->setModel(new $classModel($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
        $this->chargeModel($this->getNameController());


        if ($this->is_Erreur()) {
            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }


        return $this->ajax_js($id);
    }

    public function ajax_js($id): ResponseInterface {
        $GET = $this->getRequest()->getQueryParams();
        $query = $this->query($id, $GET);
        $ModeSelect = $this->ModeSelect($GET);



        $data = $this->getModel()->showAjax($ModeSelect, $query);
        $desplayType = $this->desplayType($GET);

        $json = Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    protected function query($id = null, $GET = []) {
        if ($id == null) {
            //var_dump($GET);
            var_dump("operateur", $this->operateur($GET));
            var_dump("by", $this->by($GET));
            var_dump("params", $this->params($GET));
            var_dump("limit", $this->limit($GET));
            die();
        } else {
            return ["id" => $id];
        }
    }

    protected function ModeSelect(array $GET): array {

        $parent = MODE_SELECT_Interface::_DEFAULT;
        $child = MODE_SELECT_Interface::_NULL;


        if (isset($GET["champs_pere"])) {
            $parent = $this->parseMode($GET["champs_pere"], $parent);
        }
        if (isset($GET["champs_fils"])) {
            $child = $this->parseMode($GET["champs_fils"], $child);
            if ($child != MODE_SELECT_Interface::_NULL) {
                
            }
        }


        return [$parent, $child];
    }

///**********************************************************************************/////
    private function desplayType(array $GET) {
        if (isset($GET["desplaytype"])) {
            $type = strtolower($GET["desplaytype"]);
            switch ($type) {
                case "json":
                    return "json";
                case "html":
                    return "html";

                default:
                    return "json";
            }
        }
        return "json";
    }

    private function parseMode(string $modefr, $default): string {
        switch ($modefr) {
            case "rien":
                $mode = MODE_SELECT_Interface::_NULL;
                break;
            case "resume":
                $mode = MODE_SELECT_Interface::_MASTER;
                break;
            case "defaut":
                $mode = MODE_SELECT_Interface::_DEFAULT;
                break;
            case "tous":
                $mode = MODE_SELECT_Interface::_ALL;
                break;

            default:
                $mode = $default;
                break;
        }
        return $mode;
    }

    private function by(array $GET): array {
        if (isset($GET["by"])) {
            return explode('|', $GET["by"]);
        }
        return ["id"];
    }

    //params :/id  or :p :p1 :p2 .....
    private function params(array $GET) {

        if (isset($GET["id"])) {
            return ["id" => $GET["id"]];
        }

        $params = [];
        foreach ($GET as $key => $value) {
            if (preg_match('/^p[0-9]+/i', $key) > 0) {

                $params[$key] = explode('|', $value);
            }
        }

        return $params;
    }

    /**
     * 
     * @param array $GET
     * @return array
     */
    private function operateur(array $GET): array {
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
            return $operateurs;
        }
        return ["="];
    }

    private function limit(array $GET): int {
        if (isset($GET["limit"])) {
            return (int) $GET["limit"];
        }
        return 0;
    }

}
