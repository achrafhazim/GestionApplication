<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationAchats extends Autorisation_TablePhinix
{

    public function change()
    {

        $this->create_autorisation("Achats");
    }
}
