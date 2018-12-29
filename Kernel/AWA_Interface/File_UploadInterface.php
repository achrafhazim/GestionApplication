<?php

namespace Kernel\AWA_Interface;

use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 *
 * @author wassime
 */
interface File_UploadInterface
{

    public function __construct(string $path);

    public function setPreffix(string $preffix);

    public function get(string $id_file): array;

    public function delete(string $id_file): array;

    public function save(array $uploadedFiles, string $preffix = ""): array;

    public function save_child(array $uploadedFiles, string $preffix = ""): array;
}
