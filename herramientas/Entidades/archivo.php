<?php

class archivos
{
    //$obj es un array
    //$path ubicacion del archivo
    //guarda el contenido del objeto en un archivo
    //en caso de que el archivo no exista lo crea
    //true=tuvo exito false=ocurio un erro
    public static function writeFile($path, $obj, $contenedor)
    {
        $retorno = false;
        foreach ($obj as $key => $value) {
            array_push($contenedor, $value);
        }

        try {
            $archivo = fopen($path, "w");
            $cant = fwrite($archivo, json_encode($contenedor));
            //fclose($archivo);

            if ($cant > 0) {
                $retorno = true;
            }
        } catch (\Throwable $th) {
            echo "Error al escrivir el archivo!!!";
        } finally {
            fclose($archivo);
            return $retorno;
        }
    }

    //$path ubicacion del archivo
    //leer el archivo en caso de error o contenido
    //vacio retorna un array vacio "[]"
    public static function readFile($path)
    {
        $contenido = array();
        try {
            if (file_exists($path)) {
                //El archivo existe
                $archivo = fopen($path, "r");

                if (filesize($path) > 0) {
                    //El archivo tiene contenido
                    $contenido = json_decode(fread($archivo, filesize($path)));
                }
                // fclose($archivo);
            }
        } catch (\Throwable $th) {
            echo "Error a leer archivo!!!";
        } finally {
            fclose($archivo);
            return $contenido;
        }
    }
    public static function moveFile($pathOrigin, $pathDestiny)
    {
        $retorno = false;

        try {
            if (copy($pathOrigin, $pathDestiny)) {
                unlink($pathOrigin);
                $retorno = true;
            }
        } catch (\Throwable $th) {
        } finally {
            return $retorno;
        }
    }
    public static function uploadFile($destino)
    {
        $retorno = false;

        try {
            $extencion = new SplFileInfo($_FILES["archivo"]["name"]);
            $extencion = "." . $extencion->getExtension();
            $origen = $_FILES["archivo"]["tmp_name"];
            move_uploaded_file($origen, $destino . $extencion);
            $retorno = true;
            echo $destino . $extencion;
        } catch (\Throwable $th) {
            echo "Error al subir archivo!!!";
        } finally {
            return $retorno;
        }
    }

    /* $archivo = fopen($path, "w");
    $cant = fwrite($archivo, json_encode($contenedor));
    //fclose($archivo);

    if ($cant > 0) {
        $retorno = true;
    } */

    public static function serializarFile($path, $obj, $contenedor)
    {
        $retorno = false;

        try {
            $serializado = serialize($obj);
            $archivo = fopen($path, "w");
            $rta = fwrite($archivo, $serializado);
            fclose($archivo);

            $retorno = true;
        } catch (\Throwable $th) {
            echo "Error al serializar archivo!!!";
        } finally {
            return $retorno;
        }
    }
    public static function deserializarFile($path, $obj, $contenedor)
    {
        $retorno = array();

        try {
            $serializado = serialize($obj);
            $archivo = fopen($path, "r");
            $rta = fread($archivo, filesize($path));
            fclose($archivo);
            if ($rta != null || $rta != "") {
                $retorno = unserialize($rta);
            }
        } catch (\Throwable $th) {
            echo "Error al deserializar archivo!!!";
        } finally {
            return $retorno;
        }
    }
}
