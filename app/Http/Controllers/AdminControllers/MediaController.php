<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Storage;

class MediaController extends AdminController
{
    public function __construct()
    {
        $this->section = 'Media';
        parent::__construct();
    }

    public function initCreating()
    {
        $media_type = Input::get('media_type');
        if (!$media_type) {
          $media_type = 'Product';
        }

        $data = [
            'input_name' => Input::get('uploader'),
            'type' => Input::get('type'),
            'upload_dir' => $this->context->core->getUploadDir(Input::get('type')) . '/',
            'media_type' => $media_type
        ];

        $id = $this->context->media->add($data);
        return jsonResponse('success', Input::get('type') . ' is uploaded');
    }

    public function initCreatingSaveEmbeded()
    {
        $fields = [
          'embed-code' => 'Embed code'
        ];

        $data = $this->context->core->validateFields($fields);

        $media = $this->context->media->fill([
          'name' => $data->embed_code,
          'type' => 'video',
          'format' => 'embed',
          'media_type' => 'Product'
        ]);

        $media->save();

        return jsonResponse('success', 'Embeded media saved');
    }

    public function initCreatingSave($id_media = null)
    {
        $media = $this->context->media->find($id_media);
        $name = $media->name;
        $media_type = Input::get('media_type');
        if (!$media_type) {
          $media_type = 'Product';
        }

        if (Input::get('new_copy')) {
          $img = Input::get('img');
          $img = str_replace('data:image/jpeg;base64,', '', $img);
          $img = str_replace(' ', '+', $img);
          $data = base64_decode($img);
          $new_name = $media->uniqueImageGenerator($name);
          file_put_contents(storage_path('media/image/' . $new_name), $data);
          $media = $this->context->force()->media;
          $media->fill([
            'name' => $new_name,
            'type' => 'image',
            'format' => pathinfo($img, PATHINFO_EXTENSION),
            'media_type' => $media_type
          ]);
        } else {
          $img = Input::get('img');
          $img = str_replace('data:image/jpeg;base64,', '', $img);
          $img = str_replace(' ', '+', $img);
          $data = base64_decode($img);
          $extension = pathinfo($name, PATHINFO_EXTENSION);
          $name_without_extension = pathinfo($name, PATHINFO_FILENAME);
          $new_name = $name_without_extension . '-c.' . $extension;
          file_put_contents(storage_path('media/image/' . $new_name), $data);
          $media->fill([
            'name' => $new_name
          ]);
        }
        $media->save();

        return jsonResponse('success', 'Image is uploaded', $media->id);
    }

    public function initCreatingSaveCropped($id_media = null)
    {
        $media = $this->context->media->find($id_media);
        $name = $media->name;
        $img = Input::get('img');
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        file_put_contents(storage_path('media/image/' . $name), $data);
        return jsonResponse('success', url('storage/media/image/' . $name));
    }

    public function initListing()
    {
        $this->page_title = 'Media Library';

        $data = [
          'media' => $this->context->media->orderBy('id', 'desc')->paginate(20)
        ];

        return $this->template('media.list', $data);
    }

    public function initContent()
    {

    }

    public function initGetLibrary($media_type = null, $object_type = null)
    {
        if (count($object_type)) {
          $object_type = $object_type;
        } else {
          $object_type = 'image';
        }
        $this->page_title = 'Media Library';

        if ($media_type && $object_type) {
          $media = $this->context->media
          ->where('media_type', $media_type)
          ->where('type', $object_type)
          ->orderBy('id', 'desc')
          ->paginate(20);
        } else {
          $media = $this->context->media->orderBy('id', 'desc')->paginate(20);
          pre($media);
        }

        $data = [
          'media' => $media
        ];

        if (Input::get('pagination') && Input::get('page')) {
          $html = getAdminTemplate('media/list-only', $data, true);
          return json('success', $html);
        }

        return $this->template('media.list-only', $data);
    }

    public function initDeleting($id_media = null)
    {
        $media = $this->context->media->find($id_media);
        Storage::delete('media/' . $media->type . '/' . $media->name);
        $media->delete();
        return json('success', 'Media deleted');
    }
}
