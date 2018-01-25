<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Input;
use App\Classes\Context;

class AdminController extends Controller
{
    protected $scope = 'admin';

    public $page_title = 'Authority Zone';

    public $context;

    public $section = 'Authority Zone';

    public $css_files = array();

    public $js_files = array();

    public $flash = array();

    public $page = array();

    protected $meta = array();

    public function __construct()
    {
        $this->context = Context::getContext();
        $this->context->core->scope = $this->scope;
        $this->page['title'] = 'Admin Zone';
        $this->page['panel'] = 'enable';
        $this->page['meta_title'] = 'Admin Zone';
        $this->page['meta_description'] = 'Admin description';
        $this->page['meta_keywords'] = '';
        $this->page['head'] = 'Default Page';
        $this->meta['title'] = 'Adlara' ;
    }

    public function template($view, $data = array())
    {
      View::addLocation(config('settings.admin_theme_abs'));

        if (!isset($this->page['action_links'])) {
          $this->page['action_links'] = [];
        }
        $media = '';
        if (Input::get('id_media')) {
          $media = $this->context->media->find(Input::get('id_media'));
        }

        $default = [
            'page_title' => $this->page_title,
            'page' => $this->page,
            'action_links' => $this->page['action_links'],
            'context' => $this->context,
            'css_files' => $this->getCSS(),
            'js_files' => $this->getJS(),
            'css_url' => url(config('settings.admin_css_url')),
            'js_url' => url(config('settings.admin_js_url')),
            'sidebar_menu' => $this->getAdminMenu(),
            'media_url' => url(config('settings.media_url')),
            'section' => $this->section,
            'media_item' => $media,
            'form' => $this->context->form,
        ];

        $data = array_merge($this->assign, $default);

        return View::make('admin'."/".config('settings.admin_theme')."/templates/".$view, $data);
    }

    public function getCSS()
    {
        $this->addCSS($this->context->link->getCSSLink('vendors.bundle.css'));
        $this->addCSS($this->context->link->getCSSLink('style.bundle.css'));
        $this->addCSS($this->context->link->getCSSLink('tagsinput.css', true));
        $this->addCSS($this->context->link->getCSSLink('media.css', true));
        $this->addCSS($this->context->link->getCSSLink('style.css'));

        return $this->css_files;
    }

    public function getJS()
    {
        $this->addJS($this->context->link->getJSLink('vendors.bundle.js'));
        $this->addJS($this->context->link->getJSLink('scripts.bundle.js'));
        $this->addJS($this->context->link->getJSLink('tagsinput.min.js', true));
        $this->addJS($this->context->link->getJSLink('cropper.min.js', true));
        $this->addJS($this->context->link->getJSLink('uploader.js', true));
        $this->addJS($this->context->link->getJSLink('media.js', true));
        $this->addJS($this->context->link->getJSLink('dashboard.js'));
        $this->addJS($this->context->link->getJSLink('core.js'));

        return $this->js_files;
    }

    public function getAdminMenu()
    {
      $co['base'] = [
        'text' => 'Base',
        'icon' => '<i class="m-menu__link-icon flaticon-layers"></i>'
        ];

          $co['base']['child'][] = [
            'slug' => 'components/base/state.html',
            'text' => 'State Colors'
          ];

      $tl['tools'] = [
        'text' => 'Tools',
        'icon' => '<i class="m-menu__link-icon flaticon-interface-3"></i>'
        ];

          $tl['tools']['child'][] = [
            'slug' => 'configuration',
            'text' => 'Configuration'
          ];

      $tl['employee'] = [
        'text' => 'Employees',
        'icon' => '<i class="m-menu__link-icon flaticon-users"></i>'
        ];

          $tl['employee']['child'][] = [
            'slug' => 'employee/list',
            'text' => 'Employees'
          ];

      //Main menu defined here
      $menu[] = [
        'head' => 'Components',
        'menu' => $co
      ];

      $menu[] = [
        'head' => 'Tools',
        'menu' => $tl
      ];

        return $menu;
    }

    public function addCSS($file, $priority = 0)
    {
        return $this->css_files[] = $file;
    }

    public function addJS($file, $priority = 0)
    {
        $this->js_files[] = $file;
    }

    public function changeStatus($id)
    {
        $statusObj = $this->statusObj->find($id);

        $status = 1;
        if (isset($statusObj->status) && $statusObj->status) {
            $status = 0;
          }

          $statusObj->status = $status;
          $statusObj->save();

        return json('success','Status Change!');
    }

    public function flashMessages()
    {
        if ($this->request->session()->get('success')) {
          $this->flash = [
            'status' => 'success',
            'message' => $this->request->session()->get('success')
          ];
        }

        if ($this->request->session()->get('warning')) {
          $this->flash = [
            'status' => 'warning',
            'message' => $this->request->session()->get('warning')
          ];
        }

        if ($this->request->session()->get('danger')) {
          $this->flash = [
            'status' => 'danger',
            'message' => $this->request->session()->get('danger')
          ];
        }

        if ($this->request->session()->get('info')) {
          $this->flash = [
            'status' => 'info',
            'message' => $this->request->session()->get('info')
          ];
        }

        return $this->flash;
    }
}
