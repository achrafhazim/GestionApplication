<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification\Comptes\Controller;

use App\AbstractModules\Controller\FileController as file;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
class FileController extends file
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        parent::process($request, $handler);

        return $this->get_views_files("show_files");
    }
}
