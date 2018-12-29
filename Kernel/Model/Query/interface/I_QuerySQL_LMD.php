<?php
/*
LMD : langage de <manipulation> des données
SELECT : sélection de données dans une table ;
INSERT : insertion de données dans une table ;
DELETE : suppression de données d'une table ;
UPDATE : mise à jour de données d'une table.
 */

namespace Kernel\Model\Query;

/**
 *
 * @author Wassim Hazime
 */
interface I_QuerySQL_LMD
{
    

    public function from(string $table, string $alias = '') ;

    public function where() ;

   

    ///delete
    public function delete();

    //insert

    public function insertInto(string $table) ;

    public function value(array $data);

    //update

    public function update(string $table) ;

    public function set(array $data) ;
}
