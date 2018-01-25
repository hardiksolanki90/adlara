<?php

namespace App\Classes;

class Form
{
    public $form = array();

    public $required = array();

    public $token = true;

    public $admin_save_buttons = array();

    public $name;

    public $required_label = array();

    public function __construct()
    {

    }

    public function media($id, $text, $obj = null, $multiple = false)
    {
        $w = false;
        $html = '';
        if ($obj && count($obj)) {
          $html .= '<div class="select-media-wrapper">';
          $w = true;
        }
        $div_id = str_replace('[]', '', $id);
        $html .= '<button '.($multiple ? 'multiple' : '').' type="button" id="'.$div_id.'" class="btn btn-media select-media" name="'.$id.'"><i class="la la-cloud-upload"></i> ' . $text . '</button>';
        if ($w) {
          $html .= generateMedia($id, $obj);
        }
        if ($w) {
          $html .= '</div>';
        }

        return $html;
    }


    public function mdtext($data = array())
    {
        $default = [
            'label' => '',
            'id' => $data['name'],
            'class' => '',
            'width' => 'full',
            'length' => 100,
            'value' => '',
            'required' => false,
            'type' => 'text',
            'wrap_class' => ''
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        $html = '<div class="field mdl-field '.$data['wrap_class'].'">
          <label class="mdl-label" for="'.$data['id'].'">'.$data['label'].($data['required'] ? '*' : '').'</label>
          <input class="mdl-input input-sm '.$data['class'].'" name="'.$data['name'].'" type="'.$data['type'].'" id="'.$data['id'].'" value="'.$data['value'].'" maxlength="'.$data['length'].'">
        </div>';

          $this->form[] = $html;
          if ($data['required']) {
              $this->required[$this->name][] = $data['name'];
              $this->required_label[$this->name][] = $data['label'];
          }

          return $html;
    }

    public function mdtextarea($data = array())
     {
         $label = '';
         $placeholder = '';
         $default = [
             'label' => '',
             'id' => $data['name'],
             'class' => '',
             'width' => 'full',
             'length' => 255,
             'value' => '',
             'rows' => 5,
             'myLabel' => false,
             'wrap_class' => '',
             'placeholder' => false,
             'required' => false
         ];

         foreach ($default as $key => $value) {
             if (!isset($data[$key])) {
                 $data[$key] = $value;
             }
         }

         $html = '<div class="field mdl-field '.$data['wrap_class'].'">
             <textarea class="mdl-input '.$data['class'].'" rows="3" name="'.$data['name'].'" type="text" id="'.$data['id'].'" '.($data['placeholder'] ? 'placeholder="'.$data['label'].'"' : '').' rows="'.$data['rows'].'"  maxlength="'.$data['length'].'">'.$data['value'].'</textarea>
             <label Class="mdl-label" for="'.$data['id'].'">'.$data['label'].($data['required'] ? '*' : '').'</label>
             <i class="bar"></i>
           </div>';

           if ($data['required']) {
             $this->required[$this->name][] = $data['name'];
             $this->required_label[$this->name][] = $data['label'];
           }

           $this->form[] = $html;

           return $html;
     }


    public function hidden($name, $value = null, $required = false)
    {
       $html = '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.($value ? $value : '').'">';

       if ($required) {
         $this->required[$this->name][] = $name;
       }

       $this->form[] = $html;

       return $html;
    }
    public function button2($data = array())
    {
        $left_icon = '';
        $right_icon = '';
        if (!isset($data['id'])) {
          $data['id'] = str_slug($data['text']);
        }

        $default = [
            'text' => $data['text'],
            'id' => $data['id'],
            'class' => '',
            'width' => 'full',
            'type' => 'button',
            'icon_position' => 'left',
            'icon' => '',
            'attr' => array(),
            'return_code' => false
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        if ($data['icon'] && $data['icon_position'] == 'left') {
            $left_icon = '<i class="'.$data['icon'].'"></i>';
        }

        if ($data['icon'] && $data['icon_position'] == 'right') {
            $right_icon = '<i class="'.$data['icon'].'"></i>';
        }

        if ($data['type'] == 'submit') {
          $data['class'] = $data['class'] . ' lb';
        }

        $attr = '';
        if (count($data['attr'])) {
          foreach ($data['attr'] as $attr_key => $attr_value) {
            $attr .= ' '.$attr_key . '="'.$attr_value.'" ';
          }
        }

        $html = '<button ' . $attr . ' type="'.$data['type'].'" class="btn btn-primary '.$data['class'].'" id="'.$data['id'].'">
        '.$left_icon. ' ' .$data['text'] . ' ' .$right_icon.'
        </button>';

        if (!$data['return_code']) {
            $this->form[] = $html;
        }

        return $html;
    }

    public function html($html) {
        $this->form[] = $html;

        return $html;
    }

    public function start($name, $class, $action = null)
    {
       $this->name = $name;
       return '<form id="'.$name.'" class="'.$class.'" method="post" action="'.$action.'">';
    }

    public function end()
    {
       if (isset($this->required[$this->name])) {
         $html = $this->hidden('required', implode(',', $this->required[$this->name]));
         $html .= $this->hidden('required_label', implode(',', $this->required_label[$this->name]));
       } else {
         $html = '';
       }

       if ($this->token) {
           $html .= $this->hidden('_token', csrf_token());
       }

       $html .= '</form>';
       return $html;
    }

    public function select($data = array(), $options = array())
    {
        $default = [
            'label' => '',
            'options' => array(),
            'value' => null,
            'name' => $data['name'],
            'id' => str_replace('[]', '', $data['name']),
            'class' => '',
            'text_key' => '',
            'value_key' => '',
            'multiple' => false,
            'required' => false,
            'attribute' => '',
            'show_label_as_option' => true,
            'div_class' => 'select-parent',
            'hide_label' => false
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        if (count($options) < 1) {
            return;
        }

        if ($data['label'] && $data['show_label_as_option']) {
          $opt = '<option value="">'.$data['label'].'</option>';
        } else {
          $opt = '';
        }

        foreach ($options as $key => $option) {
            if (!$data['text_key'] && !$data['value_key']) {
              if ($data['multiple'] == true) {
                $opt .= '<option '.(in_array($key, $data['value']) ? 'selected' : '').' value="'.$key.'">'.$option.'</option>';
              } else {
                $opt .= '<option '.($key == $data['value'] ? 'selected' : '').' value="'.$key.'">'.$option.'</option>';
              }
            } else {
              if ($data['multiple'] == true) {
                if (!count($data['value'])) {
                  $data['value'] = array();
                }
                $opt .= '<option '.(in_array($option[$data['value_key']], $data['value']) ? 'selected' : '').' value="'.$option[$data['value_key']].'">'.$option[$data['text_key']].'</option>';
              } else {
                $opt .= '<option '.($option[$data['value_key']] == $data['value'] ? 'selected' : '').' value="'.$option[$data['value_key']].'">'.$option[$data['text_key']].'</option>';
              }
            }
        }

        $html = '<div class="'.$data['div_class'].'"><label class="myLabel without-margin-top" for="'.$data['id'].'">'.$data['label'].($data['required'] ? '*' : '').'</label><select class="'.$data['class']. ' ' . ($data['multiple'] ? 'multi-select' : '') .'" name="'.$data['name'].'" id="'.$data['id'].'" '.($data['multiple'] ? 'multiple' : '').' '.$data['attribute'].'  > '.$opt.' </select></div>';

        $this->form[] = $html;
        if ($data['required']) {
            $this->required[$this->name][] = str_replace('[]', '', $data['name']);
        }

        return $html;
    }

    public function mdradio($name, $options = array(), $selected_value = null, $label = null, $inline = false)
    {
        $html = null;

        $html = '<div class="col-md-12 col-lg-12 pl-0">';
        $html .= '<div class="ml-1 '.($inline == true ? 'md-radio-inline' : '').' md-radio-list">';
        if ($label)
        {
          $html .= '<label for="'.$name.'" class="margin-right-10 inline-block">'.$label.'</label>';
        }

        if ($inline == true) {
          $html = '<div class="col-md-6 col-lg-6 padding-left-0">';
          $html .= '<div class="md-radio-inline inline-block md-radio-list">';
          $html .= '<label for="'.$name.'" class="margin-right-10">'.$label.'</label>';
        }
        if (count($options)) {
            $html .='<div class="m-radio-list m-radio-inline">';
            foreach ($options as $value => $option_name) {
              $idfor = $name.$value;
                $html .= '<label class=" m-radio m-radio--bold m-radio--state-brand"><input type="radio" id="'. $idfor .'" name="'. $name .'" class="radio" '.($value == $selected_value ? 'checked' : '').' value="'. $value .'">'. $option_name .'<span></sapn></label>';
            }
            $html .='</div>';
        }

        $html .='</div></div>';
        $this->form[] = $html;
        return $html;
    }


}
