URL = 'https://dev.adlara.com/authority';
$(document).ready(function () {
  $(document).on('focus', '.mdl-input', function () {
    $(this).parent().addClass('is-focused');
  });

  $('#meta_keywords, #ADMIN_EMAIL').tagsinput();
  $('[name=phone], [name=mobile]').inputmask('(999) 999-9999');

  $('.mdl-input').each(function () {
    if ($(this).val().length > 0) {
      $(this).parent().addClass('is-focused');
    }
  });

  $(document).on('blur', '.mdl-input', function () {
    val = $(this).val();
    if (val.length > 0) {
      $(this).parent().addClass('is-focused');
    } else {
      $(this).parent().removeClass('is-focused');
    }
  });

  $(document).on('click', '.javascript', function (e) {
      e.preventDefault();
      toggle = $(this).attr('toggle');
      hide = $(this).attr('hide');
      show = $(this).attr('show');
      scroll = $(this).attr('scroll');
      url = $(this).attr('location');
      remove = $(this).attr('remove');
      content = $(this).attr('content');
      con = $(this).attr('confirm_msg');
      method = $(this).attr('method');

      if (remove) {
        $(remove).remove();
      }

      if (hide) {
      }
      $(hide).slideUp('fast');

      if (toggle) {
        $(toggle).slideToggle('fast');
      }

      if (show) {
        $(show).slideDown('fast');
      }

      if (scroll) {
        var animate_scroll = $('html, body').stop(!0,!1).animate({
          scrollTop:$(scroll).offset().top - 50},
          500);
          clearTimeout(animate_scroll);
        }

        if (url) {
          // NProgress.configure({ showSpinner: true });
          // NProgress.start();
          if (con) {
            if (confirm(con)) {
              confirm(con);
            } else {
              // NProgress.done();
              return true;
            }
          }
          div_to_update = $(this).attr('div_to_update');
          if (div_to_update) {
            element = div_to_update;
          } else {
            element = $(this).attr('id');
          }
          if (method && method == 'post') {
            data = $(this).attr('data');
            arr = data.split(',');
            post = {};
            post['_token'] = CSRF;
            post['element'] = $(this).attr('id');
            $.each(arr, function (index, value) {
              post[value] = $('#' + value).val();
            });
            $(this).addClass('m-loader');
            $.post(url, post, '', 'json').always(function (data) {
              if (data.status == 'html') {
                ele = data.field;
                element = $('#' + ele);
                div_to_update = element.attr('div_to_update');
                if (div_to_update) {
                  $('#' + div_to_update).html(data.message);
                } else {
                  element.html(data.message);
                }
              }

              if (data.status == 'success') {
                toastr.success(data.message);
                el = $('#' + data.field);
                el.removeClass('m-loader');
                cb = el.attr('callback');
                if (cb) {
                  window[cb]();
                }
              }

              if (data.status == 'error') {
                el = $('#' + data.field);
                el.removeClass('m-loader');
                toastr.error(data.message);
              }

              if (data.status == 'redirect') {
                redirect(data.message);
              }

              // NProgress.done();
            });
          } else {
            $.get(url, {element: element}, '', 'json').always(function (data) {
              if (data.status == 'html') {
                ele = data.field;
                element = $('#' + ele);
                div_to_update = element.attr('div_to_update');
                if (div_to_update) {
                  $('#' + div_to_update).html(data.message);
                } else {
                  element.html(data.message);
                }
              }

              if (data.status == 'success') {
                toastr.success(data.message);
              }

              if (data.status == 'error') {
                toastr.error(data.message);
              }

              if (data.status == 'redirect') {
                redirect(data.message);
              }

              // NProgress.done();
            });
          }
        }
    });
});


$(document).on('submit', '.myForm', function (e) {
    $sub_button = 'button[type=submit]';
    e.preventDefault();
    if (!formValidate($(this))) {
        return false;
    }

    $($sub_button).addClass('m-loader');
    url = window.location;

    if ($(this).attr('action')) {
      url = $(this).attr('action');
    }

    $.post(url, $(this).serialize(), '', 'json').always(function (data) {
        if (data.status == 'success') {
              location.reload();
              toastr.success(data.message);
            // $('body').load(window.location + ' .big-container', function () {
            // });
        }

        if (data.status == 'redirect') {
            toastr.success('Success!');
            window.location = data.message;
            // redirect(data.message);
        }

        if (data.status == 'back') {
            window.location = document.referrer;
        }

        if (data.status == 'refresh') {
            // location.reload();
        }

        if (data.status == 'error') {
            toastr.error(data.message);
        }
        $($sub_button).removeClass('m-loader');
    }).fail(function (data) {
        toastr.error(data.message);
        $($sub_button).removeClass('m-loader');
    });
});
function formValidate(form) {
    rf = form.find('#required').val();

    if (!rf) {
      return true;
    }
    rf = rf.split(',');

    errors = false;
    $.each(rf, function(i) {
       input = '#' + rf[i];
       input_bar = form.find(input);
       if (!input_bar) {
           return;
       }
       myVal = input_bar.val();
       if (!myVal) {
          console.log(input);
           label = $(input_bar).parent().find('label');
           $(input_bar).parent().addClass('invalid');
           if (label.text() != '') {
               toastr.error(label.text() + ' is required');
           }
           errors = true;
       }
    });
    if (errors) {
        return false;
    }

    return true;
}

function table_filter()
{
  $(document).off('._ft');
  $('._ft').each(function () {
    tr_filter = $(this).find('tr.filter');
    thead = $(this).find('thead');
    th = $(this).find('th');

    html = '<tr class="filter"></tr>';
    $(tr_filter).remove();
    $(thead).append(html);

    tr_filter = $(this).find('tr.filter');
    $(th).each(function() {
      filter = $(this).attr('filter');
      if (filter && filter.length) {
        html = '<td><input type="text" id="' + filter + '" filter="' + filter + '" class="form-control _tf"></td>';
      } else {
        html = '<td>-</td>';
      }
      $(tr_filter).append(html);
    });
  });
}
