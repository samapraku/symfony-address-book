<?php

namespace App\Service;

use App\Entity\Contact;
use App\Utils\Interfaces\UploaderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService implements UploaderInterface {

    public const imageUploadFolder = '/uploads/images/';
    
    private $targetDirectory;  

    public $file;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }
    
    public function upload(UploadedFile $file){
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanedFilename = $this->clear($originalFilename);
        $fileName = $cleanedFilename.'-'.uniqid().'.'.$file->guessExtension();
        try{
            $file->move($this->getTargetDirectory(), $fileName);
        }catch(FileException $ex){

        }

        return $fileName;
    }

    private function clear($string){
        $string = preg_replace('/[^A-Za-z0-9- ]+/', '', $string);
        return $string;
    }

    public function getTargetDirectory(){
        return $this->targetDirectory;
    }

    public function delete(string $path) : bool 
    {
        $fileSystem = new FileSystem();
        try {
            $fileSystem->remove('.'.$path);
        } catch (IOExceptionInterface $exception) {
            echo "An error occured while deleting the file at ".$exception->getPath();
            return false;
        }

        return true;
    }

}