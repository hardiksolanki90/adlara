@extends('layouts.app')
@section('content')
  {!! $form->start('admin-user-create', 'myForm') !!}

      {!! $form->media('media', 'Choose Media', $admin_user->media) !!}

        {!! $form->mdtext([
          'name' => 'name',
          'label' => t('Name'),
          'required' => true,
          'value' => model($admin_user, 'name'),
          ]) !!}

        {!! $form->mdtext([
          'name' => 'email',
          'label' => t('Email'),
          'required' => true,
          'value' => model($admin_user, 'email'),
          ]) !!}

        {!! $form->mdtext([
          'name' => 'mobile',
          'type' => 'tel',
          'label' => t('Mobile'),
          'required' => true,
          'value' => model($admin_user, 'mobile'),
          ]) !!}

        @if ($id)
          {!! $form->mdtext([
            'name' => 'password',
            'label' => t('Password'),
            'required' => false,
            ]) !!}
        @else

        {!! $form->mdtext([
          'name' => 'password',
          'type'=> 'password',
          'label' => t('Password'),
          'required' => true,
          ]) !!}
        @endif

        {!! $form->button2([
          'type' => 'submit',
          'class' => '',
          'id' => 'save_user',
          'text' => 'Save User'
          ]); !!}
  {!! $form->end() !!}
@endsection
