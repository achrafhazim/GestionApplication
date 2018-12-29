<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html;

/**
 * Description of File_Upload
 *
 * @author wassime
 */
use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\UploadedFileInterface;
use const D_S;
use const ROOT;
use const ROOT_WEB;
use function count;
use function date;
use function filesize;
use function is_dir;
use function is_file;
use function mime_content_type;
use function mkdir;
use function preg_match;
use function scandir;
use function str_replace;
use function strpos;
use function unlink;

class File_Upload implements File_UploadInterface
{

    const FIN_REGEX = "_";

    private $path;
    private $path_relatif;
    private $path_absolu;
    private $preffix = "";

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->path_absolu = ROOT . "public/" . $path;
        $this->path_relatif = ROOT_WEB . $path;
    }

    /**
     * preffix exemple name table ==>clients
     */
    public function setPreffix(string $preffix)
    {
        if ($preffix != "") {
            $this->preffix = $preffix;
        }
    }

    private function get_preffix(string $id_file): string
    {
        preg_match('/([a-zA-Z\$]+)_(.+)/i', $id_file, $matches);
        if (empty($matches)) {
            return "";
        }
        $preffix = $matches[1];
        return $preffix;
    }

    public function get(string $id_file): array
    {

        $files = [];
        $preffix = $this->get_preffix($id_file);

        $dir_filesUpload = $this->path_absolu . $preffix;



        if (is_dir($dir_filesUpload)) {
            foreach (scandir($dir_filesUpload) as $file_save) { /// scan les image save
                //path de balise <img src="/.... ==> relatif
                $path = ROOT_WEB . $this->path . $preffix . D_S . $file_save;
                $file = [];

                $is_match = $this->is_match($id_file, $file_save);
                $is_file = is_file($path);

                if ($is_match && $is_file) {
                    $file["name"] = $file_save;
                    $file["path"] = $path;
                    $mime = mime_content_type($file["path"]);

                    if (strpos($mime, "pdf") !== false) {
                        $file["type"] = 'pdf';
                    } elseif (strpos($mime, "image") !== false) {
                        $file["type"] = 'image';
                    } else {
                        $file["type"] = "file";
                    }


                    $file["size"] = (filesize($file["path"]) * 0.000001) . ' MB';

                    $files[] = $file;
                }
            }
        }
        return $files;
    }

    public function delete(string $id_file): array
    {

        $files = [];
        $preffix = $this->get_preffix($id_file);
        $dir_filesUpload = $this->path_absolu . $preffix;

        if (is_dir($dir_filesUpload)) {
            /**
             * /// scan les image save
             */
            foreach (scandir($dir_filesUpload) as $file_save) {
                $path = $this->path_absolu . $preffix . D_S . $file_save;
                $etat = [];

                $is_match = $this->is_match($id_file, $file_save, self::FIN_REGEX);
                $is_file = is_file($path);

                if ($is_match && $is_file) {
                    $etat[] = unlink($path);
                }
            }


            return $etat;
        }
    }

    public function save(array $uploadedFiles, string $preffix = ""): array
    {

        /**
         * preffix exemple name table ==>clients
         */
        $this->setPreffix($preffix);
        $this->mkdir_is_not();

        $id_file = $this->preffix . "_" . date("Y-m-d-H-i-s");

        $keyFilesave = [];
        foreach ($uploadedFiles as $nameInput => $files) {
            $file_upload = [];
            foreach ($files as $file) {
                $file_upload[] = $this->insert_file_upload($file, $id_file);
            }

            $keyFilesave[$nameInput] = ["id_files" => $id_file, "count_files" => count($file_upload)];
        }
        return $keyFilesave;
    }

    public function save_child(array $uploadedFiles, string $preffix = ""): array
    {
        $this->setPreffix($preffix);
        $this->mkdir_is_not();
        $keyFilesSave = [];
        foreach ($uploadedFiles as $key => $file) {
            //exemple image_child_5 ==> 5 regex get nombre  index  and input  image
            preg_match('/([\D\d]+)_(.+)_(\d+)/i', $key, $matches);
            $input = $matches[1];
            $index = $matches[3];

            $id_file = $this->preffix . "_" . date("Y-m-d-H-i-s") . "_" . $index;

            $file_upload = [];
            $file_upload[] = $this->insert_file_upload($file, $id_file);

            $keyFilesSave[$index][$input] = ["id_files" => $id_file, "count_files" => count($file_upload)];
        }


        return $keyFilesSave;
    }

    private function insert_file_upload(UploadedFileInterface $file, string $id_file): array
    {
        $file_upload = [];
        if ($file->getClientFilename() != "" && $file->getError() == 0) {
            /// insert file upload

            $name = $id_file . self::FIN_REGEX . $file->getClientFilename();
            $type = $file->getClientMediaType();
            $path = $this->path_absolu . $this->preffix . D_S . $name;
            $size = $file->getSize();

            $file->moveTo($path);

            $file_upload = ["name" => $name, "type" => $type, "path" => $path, "size" => $size];
        }
        return $file_upload;
    }

    private function mkdir_is_not()
    {

        if (!is_dir($this->path_absolu . $this->preffix)) {
            $flag = mkdir($this->path_absolu . $this->preffix, 0777, true);
            if (!$flag) {
                echo "function mkdir_is_not()";
                die('<br>Echec lors de la création des répertoires...');
            }
        }
    }

    private function is_match(string $_id_file, string $file_save, string $finregex = ""): bool
    {
        $subject = str_replace("$", "", $file_save);
        $id_file = str_replace("$", "", $_id_file);
        $pattern = '!^' . $id_file . $finregex . '!';
        return preg_match($pattern, $subject);
    }
}
