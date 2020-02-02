<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $images;

    public function __construct($imagesDirectory)
    {
        $this->images = $imagesDirectory;
    }

    public function upload(UploadedFile $file, $directory)
    {
        $originName = $file->getClientOriginalName();
        $originalFilename = pathinfo(strval($originName), PATHINFO_FILENAME);
        $fileName = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory($directory), $fileName);
        } catch (FileException $e) {
        }

        return $fileName;
    }

    public function getTargetDirectory($directory)
    {
        return $this->$directory;
    }

    public function remove($directory, $filename)
    {
        $file = null;
        if ($filename) {
            $file = $this->getTargetDirectory($directory) . '/' . $filename;
        }
        return file_exists($file) && $file != null ? unlink($file) : null ;
    }
}
