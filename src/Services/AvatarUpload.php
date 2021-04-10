<?php
namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarUpload
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file, User $user): ?string
    {
        $fileName = $user->getId().".".$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            return $fileName;
        } catch (FileException $e) {
            return null;
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}