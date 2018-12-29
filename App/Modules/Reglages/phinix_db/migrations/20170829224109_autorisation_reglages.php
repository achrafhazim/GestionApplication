<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationReglages extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Reglages");
    }
}
