<?php

// src/Service/FileUploader.php
namespace App\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $filesTargetDirectory;
    private $slugger;

    public function __construct($filesTargetDirectory)
    {
        $this->filesTargetDirectory = $filesTargetDirectory;
        $this->slugger = new AsciiSlugger();
    }

    public function upload(UploadedFile $file, $filesTargetDirectory = null)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory().$filesTargetDirectory, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->filesTargetDirectory;
    }
}

