<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web\GET;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;

/**
 * Description of files
 *
 * @author wassim
 */
class Files {

    private $NameController;
    private $file_Upload;

    function __construct($NameController, $file_Upload) {
        $this->NameController = $NameController;
        $this->file_Upload = $file_Upload;
    }

    public function run($id) {
        //clients_2019-01-23-15-14-10
        $find = $this->NameController . "_" . $id;
        $files = $this->file_Upload->get($find);
        return $files;
    }

}
