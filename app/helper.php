<?php

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\View;
use App\Classes\Context;

/**
 * Check array our object output
 * @param  [type]  $array Array
 * @param  boolean $exit  true or false
 * @return [type]         print
 */
function pre($array, $exit = true)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';

    if ($exit) {
      exit();
    }
}

/**
 * output value if found in object or array
 * @param  [object/array] $model             Eloquent model, object or array
 * @param  [string] $key
 * @param  [boolean] $alternative_value
 * @return [type]
 */
function model($model, $key, $alternative_value = null, $type = 'object')
{
    if ($type == 'object') {
        if (isset($model->$key)) {
            return $model->$key;
        }
    }

    if ($type == 'array') {
        if (isset($model[$key]) && $model[$key]) {
            return $model[$key];
        }
    }

    return $alternative_value;
}

/**
 * getView of template
 * @param  [string] $view      Filename
 * @param  [string] $view_type Admin or Front
 */

function getView($view, $view_type = null)
{
    if (!$view_type) {
        $view_type = 'front';
    }

    if ($view_type == 'front') {
        return 'front/' . config('settings.front_theme') . '/templates/' . $view;
    }

    return 'admin/' . config('settings.admin_theme') . '/templates/' . $view;
}

/**
 * Return url with admin path
 * @param [string] $url path
 */

function AdminURL($url)
{
    return url(config('settings.admin_path') . '/' . $url);
}

/**
 *  word you want to translate
 * @param [string] $word tranlate
 * @param [string] $target
 * @param [string] $source Lang code
 */

function t($word, $target = null, $source = 'en')
{
    if (!$target) {
      $target = config('app.locale');
    }

    if ($target == 'en') {
      return $word;
    }

    $gt = new \App\Classes\Translate;
    $gt->setSource($source);
    $gt->setTarget($target);
    return $gt->translate($word);
}

/**
 * Return url with url language path
 * @param [string] $url path
 */

function urll($url)
{
    $locale = config('app.locale');
    if ($locale == 'en') {
      $locale = '';
    } else {
      $locale .= '/';
    }
    return url($locale . $url);
}

/**
 * Return url with url path
 * @param [string] $path File Name
 * @param [string] $url path
 */

function downloadFile($file, $url)
{
    return file_put_contents($file, fopen($url, 'r'));
}


/**
 * Media as Media Path
 * @param [string] $media Media Path
 * @param [integer] $size path
 */

function getMedia($media, $size = null)
{
    $extension = pathinfo($media, PATHINFO_EXTENSION);
    $img_extension = array('png', 'jpg', 'jpeg', 'JPEG', 'JPG', 'PNG', 'bmp', 'png', 'gif', 'GIF');
    $vid_extension = array('mp4');
    $pdf_extension = ['pdf'];
    $media_type = 'embeded';

    if (in_array($extension, $img_extension)) {
      $media_type = 'image';
    }

    if (in_array($extension, $vid_extension)) {
      $media_type = 'video';
    }

    if (in_array($extension, $pdf_extension)) {
      $media_type = 'pdf';
    }

    $path = 'storage/media/' . $media_type . '/';
    $abs_path = base_path($path);

    if ($media_type == 'embeded') {
      return $media;
    }

    $file = $path . '/' . $media;

    if ($size && $media_type == 'image') {
      $sizes = explode(',', $size);

      if (!file_exists($abs_path.$media)) {
        return 'http://keithmackay.com/images/picture.jpg';
      }

      $resize = resize($abs_path, $media, $sizes[0], $sizes[1]);
      return $resize;
    }

    return url($file);
}

/**
 * getll is location pass on google map api
 * @param [string] $location return with lat, lng, place_id
 */

function getLL($location)
{
    $location = str_replace(' ', '', $location);
    $location = str_replace('%20', '', $location);

    $data = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$location.'&key=AIzaSyAy8tTMqLcaD_6IHnlECPj2wtutMnTEkMU');

    $d = json_decode($data, true);

    if (count($d['results']) > 0) {
      $a['lat'] = $d['results'][0]['geometry']['location']['lat'];
      $a['lng'] = $d['results'][0]['geometry']['location']['lng'];
      $a['place_id'] = $d['results'][0]['place_id'];
      $adc = $d['results'][0]['address_components'];

      foreach ($adc as $ac) {
        if ($ac['types']['0'] == 'locality') {
          $a['city'] = $ac['long_name'];
        }

        if ($ac['types']['0'] == 'administrative_area_level_1') {
          $a['state'] = $ac['long_name'];
        }
      }

      return (object) $a;
    }
}

/**
* convert data in json
* @param [string] $status is defined like as success, error, redirect etc.
* @param [string] $message pass message
* @param [boolean] $exit true/ false
*/

function json($status, $message, $exit = true, $field = null)
{
    echo json_encode(['status' => $status, 'message' => $message, 'field' => $field]);
    if ($exit) {
        exit();
    }
}

/**
* convert data in jsonResponse
* @param [string] $status is defined like as success, error, redirect etc.
* @param [string] $message pass message
*/

function jsonResponse($status, $message, $field = null)
{
    return response()->json([
    'status' => $status,
    'message' => $message,
    'field' => $field
    ]);
}

/**
* Return Media type
* @param [string] $extension Return extension
*/

function getMediaType($extension)
{
    $type = 'embeded';

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

/**
* Return View File
* @param [string] $view view in the file
* @param [string] $data pass variable array format
*/


function getTemplate($view, $data = array(), $print = false)
{
    $context = \App\Classes\Context::getContext();
    $default_data = [
      'context' => $context
    ];

    $data = array_merge($default_data, $data);


    $html = view('front' . "/" . config('settings.front_theme') . "/" . $view, $data);

    if ($print) {
        $core = $context->core;
        $core->prepareHTML($html);
        return $core->buildHTML();
    }

    return $html;
}

/**
* Return View File
* @param [string] $view view in the file
* @param [string] $data pass variable array format
**/

function getAdminTemplate($view, $data = array(), $print = false)
{
    $context = \App\Classes\Context::getContext();
    $default_data = [
      'context' => $context
    ];

    $data = array_merge($default_data, $data);


    $html = view('admin' . "/" . config('settings.admin_theme') . "/templates/" . $view, $data);

    if ($print) {
        $core = $context->core;
        $core->prepareHTML($html);
        return $core->buildHTML();
    }

    return $html;
}

/**
* Return html View File
* @param [string] $html html view
* @param [string] $data pass variable array format
**/

function prepareHTML($html)
{
    $context = \App\Classes\Context::getContext();
    $core = $context->core;
    $core->prepareHTML($html);
    return $core->buildHTML();
}

function generateMedia($id, $mediaList, $type = 'image', $var_type = 'string')
{
    if (!isset($mediaList)) {
      return;
    }

    $ids = '';
    $t = '';
    $html = '<div id="'.$id.'_wrapper" class="preview-wrapper">';
    $ids = implode(',', $mediaList->pluck('id')->toArray());
    if (count($mediaList) > 1) {
        foreach ($mediaList as $key => $media) {
          $media_opt = $media;
          if (!$media_opt) {
            continue;
          }
          $html .= generateMediaHTML($media_opt);
        }

        if ($ids) {
          $ids .= ','.$media_opt->id;
        } else {
          $ids = ''.$media_opt->id;
        }
        $html .= generateMediaHTML($media_opt);
    } else {
      if (isset($mediaList[0])) {
        $m = $mediaList[0];
      } else {
        $m = $mediaList;
      }
      $ids = $m->id;
      $html .= generateMediaHTML($m);
    }

    $name = $id;

    if ($type != 'video'){
      $html .='<input type="hidden" id="' .$id. '" name="' .$name. '" value="' .$ids. '">';
    }
    $html .= '</div>';
    return $html;
}

function generateMediaHTML($media_opt)
{
    $type = $media_opt->type;
    $html = '';

    if ($type == 'image') {
      $html .='<div class="selected-img-preview"> <img id_media="'.$media_opt->id.'" src="'.getMedia($media_opt->name, '150, 150').'" class="full select-library-img"> <div class="img-action"> <button type="button" class="btn btn-success" id="edit-media-img" id_media="'.$media_opt->id.'">Edit</button> <button type="button" class="btn btn-danger" id="delete-media-img" id_media="'.$media_opt->id.'">Delete</button>
      </div></div>';

    } elseif ($type == "pdf") {
      $html .='<div class="selected-img-preview"><a type="pdf" class="pdf-list select-library-img" id_media="'.$media_opt->id.'" href="'.getMedia($media_opt->name, '150, 150').'"> <i class="mdi mdi-file-pdf"></i> <p class="file_name_pdf">'.$media_opt->name.'</p></a> <div class="img-action"> <button type="button" class="btn btn-success" id="edit-media-img" id_media="'.$media_opt->id.'">Edit</button> <button type="button" class="btn btn-danger" id="delete-media-img" id_media="'.$media_opt->id.'">Delete</button> </div></div>';

    } elseif ($type == "video") {
      $html .= '<div class="selected-img-preview">';
      if ($media_opt->type == 'video' && $media_opt->format == 'embed') {
        $html .='<div class="select-library-img video-selector" id_media="'.$media_opt->id.'"></div>';
        $html .= $media_opt->name;
      } elseif ($media_opt->type == 'video' && $media_opt->format != 'embed') {
        $html .='<div class="select-library-img video-selector" id_media="'.$media_opt->id.'"></div><video width="150" height="135" controls><source src="'.getMedia($media_opt->name, '150, 150').'" type="video/'.$media_opt->format.'"></video>';
      }
      $html .= '</div>';
    }

    return $html;
}

function curl_request($url)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    if($errno = curl_errno($curl)) {
        $error_message = curl_strerror($errno);
        return $error_message;
    }

    // Close request to clear up some resources
    curl_close($curl);

    return $resp;
}

function prepareString($string, array $replace)
{
    foreach ($replace as $key => $k) {
      $s = str_replace($key, $k, $string);
    }

    return $s;
}

function getNumber($string)
{
    return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
}

function ps($string)
{
    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);
    $string = str_replace('-', '', $string);
    $string = str_replace(' ', '', $string);
    return $string;
}

function psa($string)
{
    $string = str_replace('-', '', $string);
    return $string;
}

function resize($path, $image, $size1, $size2)
{
    if (!$size1 || !$size2) {
        return;
    }

    $size1 = trim($size1);
    $size2 = trim($size2);

    $background = Image::canvas($size1, $size2);

    $size_folder = $size1.'X'.$size2;
    if (!file_exists($path.$size_folder)) {
        mkdir($path.$size_folder);
    }

    $img = Image::make($path.$image);
    $img->resize($size1, $size2, function ($constraint) {
       $constraint->aspectRatio();
    });

    // Fill up the blank spaces with transparent color
    if ($img) {
        $img->resizeCanvas(null, $size2, 'center', false, array(255, 255, 255, 0));
        //$img->resize(intval($size1),intval($size2));
        // add callback functionality to retain maximal original image size
        //$background->insert($image, 'center');
        //$img->fit(intval($size1));
        $img->save($path.$size_folder.'/'.$image);
    }

    return url('storage/media/image/' . $size_folder . '/' . $image);
}

function flash($flash)
{
    $html = '';

    if ($flash) {
      $html .= '<div class="alert alert-'.$flash['status'].'">'.$flash['message'].'</div>';
    }

    return $html;
}
