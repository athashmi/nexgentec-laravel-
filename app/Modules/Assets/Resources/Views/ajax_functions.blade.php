function submit_asset_form() {
for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
     $.ajax({
            url: "{{ URL::route('admin.assets.store')}}",
            //headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: $('#asset_form').serialize(),
            success: function(response){
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#err_msgs');
               alert_hide();
               $('#asset_form')[0].reset();
            },
              error: function(data){
                  var errors = data.responseJSON;
                  //console.log(errors);
                  var html_error = '<div  class="alert alert-danger"><ul>';
                  $.each(errors, function (key, value)
                  {
                      html_error +='<li>'+value+'</li>';
                  })
                   html_error += "</ul></div>";
              $('#err_msgs').html(html_error);
              //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();

              // Render the errors with js ...
              alert_hide();
            }

          });

  }
function cahnge_server_type(server_type)
{
  if(server_type=='virtual')
  {
    $('#virtual_types').show();
     $('#virtual_server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });

  }
   if(server_type=='physical')
  {
    $('#virtual_types').hide();
  }

}
function cahnge_asset_view(asset_type)
{
  if(asset_type=='network')
  {
    $('#target_div').html($('#network_div').html());
    $('#is_static').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });

     CKEDITOR.replace( 'network_notes', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        } );
  }
  if(asset_type=='gateway')
  {
    $('#target_div').html($('#gateway_div').html());
     CKEDITOR.replace( 'gateway_notes', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        } );
  }

  if(asset_type=='pbx')
  {
    $('#target_div').html($('#pbx_div').html());

  }

   if(asset_type=='server')
  {
    $('#target_div').html($('#server_div').html());

     $('#server_type').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });

      CKEDITOR.replace( 'server_notes', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        } );
    $(".select2").select2({
          tags: true
        });
  }

}


function show_static_type(option)
{
    if(option==1)
            $('#static_type').show();
    if(option==0)
        $('#static_type').hide();
}


function update_asset() {
for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
     $.ajax({
            url: "{{ URL::route('admin.assets.update')}}",
            //headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: $('#edit_asset').serialize(),
            success: function(response){
              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#msg');
               alert_hide();
               $('#close_edit_asset').trigger( "click" );
               //$('#asset_form')[0].reset();
            },
              error: function(data){
              //console.log(data);
                  var errors = data.responseJSON;
                  //console.log(errors);
                  var html_error = '<div  class="alert alert-danger"><ul>';
                  $.each(errors, function (key, value)
                  {
                      html_error +='<li>'+value+'</li>';
                  })
                   html_error += "</ul></div>";
              $('#err_msgs_asset_edit').html(html_error);
              

              // Render the errors with js ...
              alert_hide();
            }

          });

  }