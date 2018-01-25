<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Classes\Context;

class FrontController extends Controller
{
    protected $scope = 'front';

    public $context;

    public $css_files = array();

    public $js_files = array();

    public $assign = array();

    public $flash = array();

    protected $meta = array();

    public function __construct()
    {
        $this->context = Context::getContext();
        $this->context->core->scope = $this->scope;
        $this->getCSS();
        $this->getJS();
        $this->page = [
          'title' => 'Default Front End Title',
          'name' => 'page_class'
        ];
        $this->meta['title'] = 'Adlara';
    }

    public function template($view, $data = array())
    {
        View::addLocation(config('settings.front_theme_abs'));
        $this->flashMessages();

        $default = [
            'page_title' => $this->page_title,
            'context' => $this->context,
            'css_files' => $this->css_files,
            'js_files' => $this->js_files,
            'css_url' => url(config('settings.css_url')),
            'js_url' => url(config('settings.js_url')),
            'media_url' => url(config('settings.media_url')),
            'flash' => $this->flash,
            'form' => $this->context->form,
        ];

        $data = array_merge($this->assign, $default);

        return View::make('front'."/".config('settings.front_theme')."/templates/".$view, $data);
    }

    public function getCSS()
    {
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css');
        $this->addCSS($this->context->link->getCSSLink('style.css'));

        return $this->css_files;
    }

    public function getJS()
    {
        $this->addJS('//code.jquery.com/jquery-3.2.1.min.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js');
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js');
        $this->addJS($this->context->link->getJSLink('vue.js', true));
        $this->addJS($this->context->link->getJSLink('core.js'));

        return $this->js_files;
    }

    public function addCSS($file, $priority = 0)
    {
        return $this->css_files[] = $file;
    }

    public function addJS($file, $priority = 0)
    {
        $this->js_files[] = $file;
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
