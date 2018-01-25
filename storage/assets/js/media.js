URL = 'https://dev.adlara.com/authority';
$(document).ready(function(){
    MediaReady();
});

function MediaReady() {
  $(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    url = $(this).attr('href');
    active_filter = $('._tf.active');
    if (active_filter.length) {
      const ID_TABLE = $(this).parent().parent().parent().attr('table');
      url += '&value=' + active_filter.val() + '&filter=' + active_filter.attr('filter');
      $.get(url, '', '', 'json').always(function (data) {
        $('#' + ID_TABLE + ' tbody').html(data.message);
        $('.links').html(data.field);
      });
    } else {
      redirect(url);
      $('#app').load(window.location + ' #app-r', function () {
        table_filter();
      });
    }
  });

  mediaPagination();

  $(document).on('change', '#media-type-selector, #object-type-selector', function () {
    object_type = $('#object-type-selector').val();
    $.get(URL + '/media/library/' + object_type, '', '', 'html').always(function (data) {
      toastr.success(object_type + ' media loaded');
      $('#media-library').html(data);
    });
  });
  // Start Media Js
  $(document).on('click', '.select-media', function () {
      $('.select-media').removeClass('current-activated-media');
      $(this).addClass('current-activated-media');
      old_html = $(this);
      old_class = old_html.parent()[0].className;
      html = $(this)[0].outerHTML;
      if (old_class == 'select-media-wrapper') {
        $(this).parent().addClass('active');
      }
      if (old_class != 'select-media-wrapper' && old_class != 'select-media-wrapper active') {
        new_html = '<div class="select-media-wrapper active">' + html + '</div>';
        $(this).replaceWith(new_html);
      }
      id = $(this).attr('id');
      multiple = $(this).attr('multiple');
      chosen_object = $(this).attr('object_type');
      if (chosen_object) {
        $("#object-type-selector option[value='" + chosen_object + "']").prop('selected', true);
        $('#object-type-selector').trigger('change');
      }
      $('#libraryModal').modal('show');
      $('#media-library-input').val(id);
      if (multiple) {
        $('#media-library-input').attr('multiple', 1);
      }
      $('#media-type-input').val($(this).attr('media_type'));
    });

      $(document).on('click', '#insert-selected-image', function () {
        current_elem = $('.current-activated-media');
        ot = current_elem.attr('object_type');
        object_type = $('#object-type-selector').val();
        if (ot && ot != object_type) {
          toastr.error('Sorry! We are expecting <strong>' + ot + '</strong> file');
          return true;
        }
        element = $('#media-library-input').val();
        multiple = $('.select-media.current-activated-media').attr('multiple');
        output = $('.select-media.current-activated-media').attr('output');
        $('.select-media-wrapper.active .preview-wrapper').remove();
        $('.current-activated-media-wrapper').removeClass('current-activated-media-wrapper');
        $('<div id="' + element + '_wrapper" class="preview-wrapper current-activated-media-wrapper"></div>').insertAfter('.current-activated-media');
        $('.inner-div.selected').each(function (i, obj) {
          if (object_type == 'image') {
            img = $(this).find('img');
          }

          if (object_type == 'pdf') {
            img = $(this).find('a');
          }

          if (object_type == 'video') {
            img = $(this);
          }

          img_html = '<div class="selected-img-preview">' + $(this).html() + '</div>';
          $('.current-activated-media-wrapper').append(img_html);
          console.log(element);
          input_element = $('.select-media-wrapper.active').find('input#' + element);
          value = input_element.val();
          if (typeof value !== "undefined" && value.length) {
            value = value + ',' + img.attr('id_media');
            $(input_element).val(value);
          } else {
            value = img.attr('id_media');
            html = '<input type="hidden" id="'+element+'" name="'+element+'" value="'+value+'">';
            $('.current-activated-media-wrapper').append(html);
          }
        });
        $('#libraryModal').modal('hide');
        $('.select-media-wrapper').removeClass('active');
      });

      $(document).on('click', '#edit-selected-image', function () {
        $('.img_crop_append').html('');
        $('.img_crop_append').addClass('owl-carousel owl-theme');
        $('.inner-div.selected').each(function (i, obj) {
          html = '<div class="item">' + $(this).html() + '</div>';
          $('.img_crop_append').append(html);
        });
        $('#libraryModal').modal('hide');
        $('#mediaModal').modal('show');
        $('#mediaModal').on('shown.bs.modal', function() {
          slider();
          cropper();
        });
      });

      $(document).on('click', '.select-library-img', function () {
        $('.select-media-wrapper.active .current-activated-media-wrapper').remove();
        id_img = $(this).attr('id_media');
        multiple = $('.select-media.current-activated-media').attr('multiple');
        if (id_img) {
          if (multiple) {
            if ($(this).parent().hasClass('selected')) {
              $(this).parent().removeClass('selected');
            } else {
              $(this).parent().addClass('selected');
            }
            $('.media-action-bar').show();
          } else {
            $('.inner-div').removeClass('selected');
            $(this).parent().addClass('selected');
            $('.media-action-bar').show();
          }
        }
      });

      $(document).on('click', '#cropper', function () {
        cropper();
        window.dispatchEvent(new Event('resize'));
      });

      $(document).on('click', '#insert-origional', function () {
        $('#mediaModal').modal('hide');
      });

      $(document).on('click', '#back-to-library', function () {
        $('#mediaModal').modal('hide');
        $('#libraryModal').modal('show');
      });

      $(document).on('click', '#edit-media-img', function () {
        img = $(document).find('img[id_media='+ $(this).attr('id_media') + ']');
        id_img = img.attr('id_media');
        $('#libraryModal').modal('hide');
        $('.img_crop_append').html('<img class="image_crop" src="' + img.attr('src') +'" alt="">');
        $('#mediaModal').modal('show');
        $('#id_media_identifier').val(id_img);
        $('.inner-div').removeClass('selected');
        $('#mediaModal').on('shown.bs.modal', function() {
          cropper();
        });
      });

      $(document).on('click', '#delete-media-img', function () {
        id_media = $(this).attr('id_media');
        if (id_media) {
          $.get(URL + '/media/delete/' + id_media, '', '', 'json').always(function (data) {
            media_library_loader();
          });
        }
      });

      $(document).on('click', '#save-cropped, #resize', function () {
        $(this).addClass('loadingi');
        img = $('.image_crop').cropper('getCroppedCanvas').toDataURL("image/jpeg", '0.9');
        id_media = $('#id_media_identifier').val();
        $.post(URL + '/media/save/' + id_media, {img: img, _token: CSRF}, '', 'json').always(function (data) {
          type = $('#media-type-selector').val();
          object_type = $('#object-type-selector').val();
          $.get(URL + '/media/library/' + type + '/' + object_type, '', '', 'html').always(function (data) {
            $('#media-library').html(data);
            toastr.success(type + ' media loaded');
          });
          $('#mediaModal').modal('hide');
          $('#libraryModal').modal('show');
          $('.nav-tabs a[href="#b"]').tab('show');
          toastr.success(data.message);
          $('#save-cropped').removeClass('loadingi');
        }).fail(function (data) {
          toastr.error('There is some error');
          $('#save-cropped').removeClass('loadingi');
        });
      });

      $(document).on('click', '#insert-cropped', function () {
        $(this).addClass('loadingi');
        img = $('.image_crop').cropper('getCroppedCanvas').toDataURL("image/jpeg", '0.9');
        id_media = $('#id_media_identifier').val();
        $.post(URL + '/media/save/cropped/' + id_media, {img: img, _token: CSRF}, '', 'json').always(function (data) {
          input = $('#media-library-input').val();
          $('input#' + input).val(id_img);
          result = $('.image_crop').cropper('getCroppedCanvas');
          $('.selected-img-preview').html(result);
          $('#' + input).val(id_img);
          $('#mediaModal').modal('hide');
          $('#insert-cropped').removeClass('loadingi');
        }).fail(function (data) {
          toastr.error('There is some error');
          $('#save-cropped').removeClass('loadingi');
        });
      });

      $(document).on('click', '#save-cropped-copy', function () {
        $(this).addClass('loadingi');
        img = $('.image_crop').cropper('getCroppedCanvas').toDataURL("image/jpeg", '0.9');
        id_media = $('#id_media_identifier').val();
        $.post(URL + '/media/save/' + id_media, {img: img, _token: CSRF, new_copy: true}, '', 'json').always(function (data) {
          toastr.success(data.message);
          media_library_loader();
        }).fail(function (data) {
          toastr.error('There is some error');
          $('#save-cropped').removeClass('loadingi');
        });
      });

      $(document).on('click', '.crop-action', function () {
          method = $(this).attr('data-value');

          switch (method) {
            case 'zoom-in':
              $('.image_crop').cropper('zoom', 0.1);
            break;
            case 'zoom-out':
              $('.image_crop').cropper('zoom', -0.1);
            break;
            case 'rotate-in':
              $('.image_crop').cropper('rotate', 45);
            break;
            case 'rotate-out':
              $('.image_crop').cropper('rotate', -45);
            break;
          }
        });

      upload('#media-uploader', URL + '/media');

}

function upload(element, url, type = 'image', image_type = 'show_image', current_action = null)
{
    allowed = ['jpg', 'jpeg', 'png', 'gif', 'MP4', 'mp4', 'pdf', 'PDF', 'avi', 'wmv', 'vob', 'flv'];
    var elementh = element;
    var myuploader = element;
    progress = document.getElementById('progress');
    var uploader = new ss.SimpleUpload({
        dropzone: 'dragbox',
        multiple: true,
        button: myuploader, // HTML element used as upload button
        url: url, // URL of server-side upload handler
        name: myuploader, // Parameter name of the uploaded file,
        startXHR: function() {
            $(element).addClass('loadingi');
            $('.progress').show();
            this.setProgressBar(progress);
        },

        endXHR: function() {
        },

        data: {
            '_token': CSRF,
            'uploader': myuploader,
            'type': type,
            'current_action': current_action
        },

        responseType: 'json',
        allowedExtensions: allowed,
        maxSize: 10024,

        onComplete: function(filename, response) {
            object_type = $('#object-type-selector').val();
            if (object_type.length) {
              $.get(URL + '/media/library/' + object_type, '', '', 'html').always(function (data) {
                $(element).removeClass('loadingi');
                $('#media-library').html(data);
                toastr.success('Finished uploading');
                $('.progress').hide();
                $('.nav-tabs a[href="#b"]').tab('show');
              });
            } else {
              new_element = element + '-preview';
              slider_element = element + '-preview-refresh';
              console.log(new_element);
              $(new_element).load(window.location + ' ' + element + '-preview-refresh', function () {
                $(element).removeClass('loadingi');
                toastr.success('Finished uploading');
                $('.progress').hide();
              });
            }
        },

        onError: function(filename, response, uploadBtn, fileSize, data) {
          object_type = $('#object-type-selector').val();
          if (object_type.length) {
            $.get(URL + '/media/library/' + object_type, '', '', 'html').always(function (data) {
              $(element).removeClass('loadingi');
              $('#media-library').html(data);
              toastr.success('Finished uploading ' + object_type);
              $('.progress').hide();
              $('.nav-tabs a[href="#b"]').tab('show');
            });
          } else {
            new_element = element + '-preview';
            slider_element = element + '-preview-refresh';
            console.log(new_element);
            $(new_element).load(window.location + ' ' + element + '-preview-refresh', function () {
              $(element).removeClass('loadingi');
              toastr.success('Finished uploading ' + type);
              $('.progress').hide();
            });
          }
        }
    });
}

function cropper(method)
{
  if (!method) {
    method = '';
  }
  $('.image_crop').cropper({
    cropend: function () {
      result = $('.image_crop').cropper('getCroppedCanvas');
      $('#crop-preview').html(result);
      $('#download-preview').show();
      $('#download-preview').attr('href', result.toDataURL('image/jpeg'));
    },
    crop: function(e) {
      // Output the result data for cropping image.
      $('#selected-width').val(e.width);
      $('#selected-height').val(e.height);
      console.log(e.x);
      console.log(e.y);
      console.log(e.width);
      console.log(e.height);
      console.log(e.rotate);
      console.log(e.scaleX);
      console.log(e.scaleY);
    },
    method
  });
}

$(document).on('click', '#scale', function () {
  $(this).addClass('loadingi');
  width = $('#image-width').val();
  height = $('#image-height').val();
  id_media = $('#id_media_identifier').val();
  img = $('.image_crop').cropper('getCroppedCanvas', {width: width, height: height}).toDataURL("image/jpeg", '0.9');

  $.post(URL + '/media/save/' + id_media, {img: img, _token: CSRF, new_copy: true}, '', 'json').always(function (data) {
    toastr.success(data.message);
    window.location = window.location.href.split('?')[0] + '?id_media=' + data.field;
  }).fail(function (data) {
    toastr.error('There is some error');
    $('#scale').removeClass('loadingi');
  });

});

function mediaPagination()
{
    $(document).on('click', '.media-link .pagination a', function (event) {
      event.preventDefault();
      event.stopImmediatePropagation()
      link = $(this).attr('href');
      $('#media_page').val($(this).text());
      $.get(link, {pagination: true}, '', 'json').always(function (data) {
        $('#media-library').html(data.message);
      });
    });
}

function window_load()
{
  cropper();
  need_media = $('.need-media');
  if (need_media.length > 0) {
    object_type = $('#object-type-selector').val();
    $.get(URL + '/media/library/image', '', '', 'json').always(function (data) {
      $('#media-library').html(data.message);
    });
  }
}
