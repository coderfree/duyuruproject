<?php

namespace App\Controllers;

use function MongoDB\BSON\toJSON;

class FileController extends BaseController
{



    public function getFileUpload($request, $response)
    {


        $directory = $this->container->upload_directory;

        $this->container->view->render($response, 'admin/dosya/yukle.twig');
    }

    public function moveUploadedFile($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    public function postFileUpload($request, $response)
    {
        $directory = $this->container->upload_directory;
        $uploadedFiles = $request->getUploadedFiles();
        foreach ($uploadedFiles['image'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $sonuc = true;
            } else $sonuc = false;
        }
        //print_r($file['image'][0]);
//die();
        $donen = ['name' => $this->container->csrf->getTokenName(), 'value' => $this->container->csrf->getTokenValue(), 'sonuc' => $sonuc];
        $name = $this->container->csrf->getTokenName();
        $value = $this->container->csrf->getTokenValue();
        $deneme = json_encode($donen);
        return ($deneme);
    }


}