<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationRapports extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Rapports");
    }
}
