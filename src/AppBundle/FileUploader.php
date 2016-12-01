<?php
/**
 * Created by PhpStorm.
 * User: Marcin
 * Date: 2016-11-23
 * Time: 18:59
 */

namespace AppBundle;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader extends UploadedFile
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

}