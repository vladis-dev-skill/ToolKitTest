<?php
declare(strict_types=1);

namespace App\Common\Controller\Media;

use App\Common\Entity\MediaObject;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vich\UploaderBundle\Storage\StorageInterface;

final class CreateMediaObjectAction
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }

    public function __invoke(Request $request): MediaObject
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        if ($uploadedFile === null) {
            throw new BadRequestHttpException('exceptions.media_object.file_required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->setFile($uploadedFile);
        $resolveUri = $this->storage->resolveUri($mediaObject, 'file');
        if ($resolveUri) {
            $resolveUri = \substr($resolveUri, 1);
        }

        $mediaObject->setContentUrl($resolveUri);

        return $mediaObject;
    }

}