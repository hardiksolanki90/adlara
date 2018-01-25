<div id="mediaModal" class="modal fade media-box" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Media Details</h4>
      </div>
      <div class="modal-body without-padding flex o-hidden">
        <div class="left-box left-box-modal2 img_crop_append">
        </div>
        <div class="right-box">
          {!! $form->hidden('id_media_identifier', '') !!}
          <div class="flex">
              {!! $form->mdtext([
              'name' => 'image-width',
              'label' => 'Image Width'
              ]) !!}

              {!! $form->mdtext([
                'name' => 'image-height',
                'label' => 'Image Height'
                ]) !!}

              <div class="form-group">
                <label for=""></label>
                {!! $form->button2([
                  'text' => 'Scale',
                  'id' => 'scale',
                  'type' => 'submit'
                  ]) !!}
              </div>
          </div>
          <h4>Preview</h4>
          <div id="crop-preview"></div>
          {!! $form->button2([
            'text' => 'Save Cropped',
            'id' => 'save-cropped',
            'class' => 'btn-danger'
            ]) !!}
          {!! $form->button2([
            'text' => 'Save as New Copy',
            'id' => 'save-cropped-copy',
            'class' => 'btn-success'
            ]) !!}
        </div>
      </div>
      <div class="modal-footer flex space-between">
        <div class="cropper-action-bar">
          {!! $form->button2([
            'text' => '<i class="material-icons">&#xE8B6;</i>',
            'id' => 'zoom',
            'class' => 'crop-action',
            'attr' => [
              'data-value' => 'zoom-in'
            ],
            ]); !!}

          {!! $form->button2([
            'text' => '<i class="material-icons">&#xE909;</i>',
            'id' => 'zoom',
            'class' => 'crop-action',
            'attr' => [
              'data-value' => 'zoom-out'
            ]
            ]); !!}

          {!! $form->button2([
            'text' => '<i class="material-icons">&#xE419;</i>',
            'id' => 'zoom',
            'class' => 'crop-action',
            'attr' => [
              'data-value' => 'rotate-in'
            ],
            ]); !!}

          {!! $form->button2([
            'text' => '<i class="material-icons">&#xE41A;</i>',
            'id' => 'zoom',
            'class' => 'crop-action',
            'attr' => [
              'data-value' => 'rotate-out'
            ],
            ]); !!}
        </div>
        <button type="button" class="btn btn-default" id="back-to-library"><i class="mdi mdi-reply"></i> Back to Library</button>
      </div>
    </div>
  </div>
</div>
