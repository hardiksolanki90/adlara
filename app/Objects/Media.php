<?php

namespace App\Objects;

use App\Objects\IDB;
use Hash;
use App\Classes\Uploader;

class Media extends IDB
{
    protected $table = 'media';

    public $guarded = [];

    public function add($data = array())
    {
        if (!$data['input_name'] || !$data['upload_dir'] || !$data['type']) {
            return;
        }

        $default = [
            'id_user' => 0,
            'admin_upload' => 0
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        $uploader = new Uploader($data['input_name']);
        // Handle the upload
        $result = $uploader->handleUpload($data['upload_dir']);

        if ($result && $uploader->getFileName()) {
            $image_name = $uploader->getFileName();
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
              $type = 'image';
            }

            if (in_array($extension, ['mp4', 'MP4', 'FLV', 'flv', 'avi', 'AVI'])) {
              $type = 'video';
            }

            if (in_array($extension, ['pdf'])) {
              $type = 'pdf';
            }

            if (in_array($extension, ['mp3'])) {
              $type = 'audio';
            }

            $media = new Self();
            $media->fill([
                'name' => $image_name,
                'type' => $type,
                'format' => pathinfo($image_name, PATHINFO_EXTENSION),
                'media_type' => $data['media_type']
            ]);
            $media->save();
            return $media->id;
        }
    }

    public function uniqueImageGenerator($image)
    {
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $image_name = pathinfo($image, PATHINFO_FILENAME);

        $image = str_slug($image_name);
        $image = str_replace('/', '', $image);
        $image = str_replace('.', '', $image);

        $check = $this->check($image.'.'.$extension);

        if ($check) {
            $image = $image_name . '-' . time() .'.'.$extension;
            return $this->uniqueImageGenerator($image);
        } else {
            return $image.'.'.$extension;
        }
    }

    public function check($name)
    {
        $this->primaryKey = 'name';
        $data = self::find($name);
        if (isset($data->id) && $data->id) {
            return true;
        }

        return false;
    }

    public function delete()
    {
      $file = storage_path('media/' . $this->type . '/' . $this->name);

      if (file_exists($file)) {
          @unlink($file);
      }

      return parent::delete();
    }

    public function getMediaType($extension)
    {
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
          $type = 'image';
        }

        if (in_array($extension, ['mp4', 'MP4', 'FLV', 'flv', 'avi', 'AVI', 'wmv', 'vob'])) {
          $type = 'video';
        }

        if (in_array($extension, ['pdf'])) {
          $type = 'pdf';
        }

        if (in_array($extension, ['mp3'])) {
          $type = 'audio';
        }

        return $type;
    }
}
