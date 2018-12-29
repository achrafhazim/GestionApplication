<?php

use App\Authentification\Autorisation_Event;
use Kernel\AWA_Interface\EventInterface;
use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\ModelInterface;

$container = $app->getContainer();

$modules = $app->getModules();
$model = $container->get(ModelInterface::class);
$File_Upload = $container->get(File_UploadInterface::class);


/*
 * metode __invok
 */
$autorisation_init = new Autorisation_Event($model, $modules);
$app->addEvent("autorisation_init", $autorisation_init);

/**
 * callable
 */
$app->addEvent("delete_files", function(EventInterface $event)use ($File_Upload) {
    $url_id_file = $event->getParam("url_id_file");
    preg_match('!(.+)'
            . 'data-regex="/(.+)/"'
            . '(.+)!i', $url_id_file, $matches);
    if (!empty($matches) && isset($matches[2])) {
        $File_Upload->delete($matches[2]);
    }
});
