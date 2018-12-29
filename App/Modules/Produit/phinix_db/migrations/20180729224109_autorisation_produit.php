<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationProduit extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Produit");
    }
}
