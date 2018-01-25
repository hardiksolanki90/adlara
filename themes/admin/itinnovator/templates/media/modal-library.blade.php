<div id="libraryModal" class="modal fade media-box-library" role="dialog">
  <div class="need-media" location="{{ AdminURL('media/library/image') }}">

  </div>
  <input type="hidden" id="media-library-input">
  <input type="hidden" id="media-type-input">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Media Library</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active lib" href="#b"  data-toggle="tab">Media Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#a" data-toggle="tab">Upload Files</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#c" data-toggle="tab">Add Embed Code</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="b">
            <div class="flex">
                {!! $form->select([
                  'name' => 'object-type-selector',
                  'class' => 'media-library-select',
                  'div_class' => 'media-library-selectors'
                  ], [
                  'image' => 'Images',
                  'video' => 'Videos',
                  'pdf' => 'PDF',
                  'audio' => 'Audio',
                  ]) !!}
            </div>
            <input type="hidden" name="" id="media_page" value="1">
            <div class="" id="media-library">

            </div>
          </div>
          <div class="tab-pane" id="a">
           <div id="dragbox">
             <h2 class="upload-instructions drop-instructions">Drop files anywhere to upload</h2>
             <p class="upload-instructions drop-instructions">or</p>
             <button type="button" id="media-uploader" class="btn btn-hero">Select Files</button>
           </div>
           <div class="progress none">
             <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="0"
             aria-valuemin="0" aria-valuemax="100" style="width:0%">
             </div>
           </div>
         </div>
          <div class="tab-pane" id="c">
            <div class="margin-top-bottom-10">
              <form class="saveEmbedMedia" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row" id="embed-clone">
                  <div class="col-md-6">
                    {!! $form->mdtext([
                      'name' => 'embed-code',
                      'label' => 'Embed Code',
                      'length' => 255
                      ]) !!}
                    <button type="button" id="save-embed-video" method="post" data="embed-code" class="btn btn-primary javascript" location="{{ AdminURL('media/save/embeded') }}" name="button">Save Video</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer flex space-between">
        <div class=""></div>
        <div class="">
          <div class="media-action-bar none">
            {!! $form->button2([
              'text' => 'Select',
              'id' => 'insert-selected-image',
              'class' => 'btn-success'
              ]) !!}
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
