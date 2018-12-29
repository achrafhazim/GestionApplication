<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationTransactions extends Autorisation_TablePhinix
{

    public function change()
    {
        $this->create_autorisation("Transactions");
    }
}
