<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationVentes extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Ventes");
    }
}
