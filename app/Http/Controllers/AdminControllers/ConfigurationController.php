<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Request;
use Illuminate\Support\Facades\Cache;
use App\Objects\Configuration;

class ConfigurationController extends AdminController
{

  public $model = 'configuration';

  public function __construct()
  {
      $this->section = 'Configuration';
      parent::__construct();
  }

  public function initContentCreate($id = null)
  {
    $this->page['title'] = 'Configuration';
    $this->page['head'] = 'Configuration';

    $this->page['action_links'][] = [
      'text' => 'Clear Cache',
      'class' => 'javascript',
      'slug' => 'clear/cache',
      'icon' => '<i class="la la-trash"></i>',
    ];


    $configuration = $this->context->configuration;

    $ADMIN_EMAIL = $configuration
    ->where('name', '=', 'ADMIN_EMAIL')
    ->pluck('value');
    $SITE_URL = $configuration
    ->where('name', '=', 'SITE_URL')
    ->pluck('value');
    $SSL = (array) $configuration
    ->where('name', '=', 'SSL')
    ->pluck('value');
    $CACHE = (array) $configuration
    ->where('name', '=', 'CACHE')
    ->pluck('value');
    $MAINTENANCE = (array) $configuration
    ->where('name', '=', 'MAINTENANCE')
    ->pluck('value');
    $DEBUG_MODE = (array) $configuration
    ->where('name', '=', 'DEBUG_MODE')
    ->pluck('value');

    $last_SSL = end($SSL);
    $last_CACHE = end($CACHE);
    $last_MAINTENANCE = end($MAINTENANCE);
    $last_DEBUG_MODE = end($DEBUG_MODE);

    $optionValue = array('1' => 'Yes', '0' => 'No');

    $this->assign = [
      'optionValue' => $optionValue,
      'ADMIN_EMAIL' => $ADMIN_EMAIL[0],
      'SITE_URL' => $SITE_URL[0],
      'last_SSL' => $last_SSL[0],
      'last_CACHE' => $last_CACHE[0],
      'last_MAINTENANCE' => $last_MAINTENANCE[0],
      'last_DEBUG_MODE' => $last_DEBUG_MODE[0],
    ];

    return $this->template('configuration.create');

  }

  public function initProcessCreate($id = null)
  {
      $data = Request::all();
      foreach ($data as $key => $d) {
        $configuration = Configuration::where('name', $key)->update([
          'name' => $key,
          'value' => $d
        ]);
      }

      return json('success', 'Configuration updated');
  }

  public function initProcessClearCache()
  {
      Cache::flush();
      return jsonResponse('success', 'Cache Clear');
  }

}
