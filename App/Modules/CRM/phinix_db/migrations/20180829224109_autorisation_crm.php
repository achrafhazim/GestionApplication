<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationCrm extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("CRM");
    }
}
