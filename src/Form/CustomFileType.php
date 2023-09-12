<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomFileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $file = $data instanceof UploadedFile ? $data : null;
            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/webp',
            ];
            if ($file instanceof UploadedFile) {
                $mime = $file->getMimeType();
                if (!in_array($mime, $allowedMimeTypes, true)) {
                    $form->addError(new FormError('Seulement les images JPEG, PNG ou WEBP sont acceptées'));
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

    public function getParent(): string
    {
        return FileType::class;
    }
}