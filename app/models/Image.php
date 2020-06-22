<?php

namespace app\models;

use \Exception;

class Image
{
    private $path;

    public function uploadImage($photo, $folder)
    {
        $folders = ["events"];

        if (!empty($photo)) {

            if (in_array($folder, $folders)) {
                $imageDirectory = IMG_UPLOADS . '/' . $folder . '/';
                echo $imageDirectory;

                if (!file_exists($imageDirectory)) {
                    mkdir($imageDirectory);
                }

                if ($photo['name'] != '') {
                    $extensionsAllow = ['png', 'jpg'];
                    $maxSize         = 5000000;
                    $name            = basename($photo['name']);

                    $file = $imageDirectory . $name;

                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

                    if (in_array($fileExtension, $extensionsAllow)) {
                        if ($photo['size'] < $maxSize) {
                            if (move_uploaded_file($photo["tmp_name"], $file)) {
                                $ruta       = IMG_FRONT_ROOT . '/' . $folder . '/' . $name;
                                $this->path = $ruta;
                            } else {
                                throw new Exception("Error al mover la Foto.");
                            }
                        } else {
                            throw new Exception("Error, Se excedio el tamaño permitido.");
                        }
                    } else {
                        throw new Exception("Error, formato de foto no permitida.");
                    }
                } else {
                    throw new Exception("Error, pongale un nombre a la foto.");
                }
            } else {
                throw new Exception("Error, selecciono la carpeta de destino incorrecta.");
            }
        } else {
            $this->path = null;
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($newVal)
    {
        return $this->path = $newVal;
    }
}
