<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationComptes extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Comptes");
    }
}
