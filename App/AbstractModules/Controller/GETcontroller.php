<?php

       //display
        //JSON
        //   affiche liset      methode get        /api/controle            variable GET
        //                                         /api/controle/id=:id    variable GET
        //                                         /api/controle?......    variable GET
        

        /*
         *by    filde_where default id
         params :/id  or :p :p1 :p2 .....
         * Opérateur op default = Égale

                    =	        |  e       |  Égale
                    !=	        |  pe      |  Pas égale
                    >	        |  s       |  Supérieur à
                    <	        |  i       |  Inférieur à
                    >=	        |  se      |  Supérieur ou égale à
                    <=	        |  ie      |  Inférieur ou égale à
                    IN	        |  in      |  Liste de plusieurs valeurs possibles
                    BETWEEN	    |  between |  Valeur comprise dans un intervalle donnée (utile pour les nombres ou dates)
                    LIKE	    |  like    |  Recherche en spécifiant le début, milieu ou fin d'un mot.
                    IS NULL	    |  null    |  Valeur est nulle
                    IS NOT NULL	|  notnull |  Valeur n'est pas nulle
         
          *LIMIT   limit      default null





         * ORDER BY   colonne1 DESC, colonne2 ASC
           orderby default id
           suffixe default ASC  (ASC ;DESC)




         * desplayType default json
         * getModeShow
         - select_pere default MODE_SELECT_Interface::_DEFAULT
         - select_fils default MODE_SELECT_Interface::_NULL




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

        //action
        //JSON
        //   action add         methode post     /api/controle              variable GET
        //   action update      methode put      /api/controle/:id          variable GET
        //   action delete      methode delete   /api/controle/:id          variable GET
        //html
        //   affiche liset      methode get        /controle/new            variable GET
        //                                         /controle/edit/:id       variable GET
        //                                         /controle/delete/:id     variable GET
        //                                         /controle/delete?startid=:id&stopid=:id variable GET


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

    public function desplayType(array $query) {
        if (isset($query["desplayType"])) {
            return $query["desplayType"];
        }
        return "json";
    }


    public function condition(array $query) {
        
    }

    public function ajax_js($id): ResponseInterface {
        $query = $this->getRequest()->getQueryParams();

        if ($id == 0) {
            $condition = $this->condition($query);
        } else {
            $condition = "id=$id";
        }



        $modeshow = $this->getModeShow($query);
        $desplayType = $this->desplayType($query);
        //  $fitlre = $this->fitlre($query);
        //$limit = $this->limit($query);
        // $ordeby = $this->ordeby($query);





        $modeSelect = $modeshow["modeSelect"];

        $Model = $this->getModel();

        $data = $Model->showAjax($modeSelect, $condition);
        //var_dump($condition);die();
        $json = Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    protected function getModeShow(array $modeHTTP): array {

        $parent = MODE_SELECT_Interface::_DEFAULT;
        $child = MODE_SELECT_Interface::_NULL;

        $type = "json";
        if (isset($modeHTTP["pere"])) {
            $parent = $this->parseMode($modeHTTP["pere"], $parent);
        }
        if (isset($modeHTTP["fils"])) {
            $child = $this->parseMode($modeHTTP["fils"], $child);
            if ($child != MODE_SELECT_Interface::_NULL) {
                $type = "HTML";
            }
        }


        return ["type" => $type, "modeSelect" => [$parent, $child]];
    }
///**********************************************************************************/////
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
    
    private function by($param) {
        
    }
     private function param($param) {
        
    }
     private function operateur($param) {
        
    }
      private function limit($param) {
        
    }

}
