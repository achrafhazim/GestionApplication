<?php

use App\App;
use App\Middleware\Authentification;
use App\Modules\Reglages\ReglagesModule;
use App\Modules\Achats\AchatsModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Produit\ProduitModule;
use App\Modules\Rapports\RapportsModule;
use App\Modules\Transactions\TransactionsModule;
use App\Modules\Ventes\VentesModule;
use Kernel\AWA_Interface\RendererInterface;

/**
 * creer application and set configue container
 */
/**
 *  configue container
 */
$configue = ROOT . "Config" . D_S . "Config_Container.php";


$app = App::getApp($configue);


$container = $app->getContainer();
//charge module
if (empty($app->getModules())) {



    $app->addModule(RapportsModule::class);
    $app->addModule(ReglagesModule::class);

    $app->addModule(ProduitModule::class);

    $app->addModule(CRMModule::class);
    $app->addModule(AchatsModule::class);



    $app->addModule(VentesModule::class);
    $app->addModule(TransactionsModule::class, [
            //  new Authentification($container)
            ]
    );

    $app->run_modules(); // ===> not run method charge and run
}
