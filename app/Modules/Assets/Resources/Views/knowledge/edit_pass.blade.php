<div class="modal fade" id="modal-edit-knowledge-pass" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Password</h4>
      </div>
      <div class="modal-body">
          <div id="err_edit_passwords">
          </div>
        <form id="update_password">
            <div class="form-group col-lg-12">
                <label>Customer</label>
                {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_pass_customer'])!!}
                <input type="hidden" name="id" value="" >

            </div>

            <div class="form-group col-lg-12">
                <label>System</label>
                {!! Form::input('text','system',null, ['placeholder'=>"System",'class'=>"form-control"]) !!}

            </div>
            <div class="form-group col-lg-12">
                <label>Login</label>
                 {!! Form::input('text','login',null, ['placeholder'=>"Login",'class'=>"form-control"]) !!}

            </div>
            <div class="form-group col-lg-12">
                <label>Password</label>
                 {!! Form::input('text','password',null, ['placeholder'=>"Password",'class'=>"form-control"]) !!}

            </div>

            <div class="form-group col-lg-12">
  	            <label>Notes</label>
  	            {!! Form::textarea('notes',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'edit_password_notes','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_knowledge_pass">Close</button>
          <button  class="btn btn-primary update_knowledge_pass">
             Update
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-edit-knowledge-pass').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/knowledge/edit/password/'+Id,function(response ) {

		if(response.password.customer)
		$('option[value="'+response.password.customer.id+'"]', $('#edit_pass_customer')).prop('selected', true);

        $('#edit_pass_customer').multiselect('refresh');

        $(e.currentTarget).find('input[name="system"]').val(response.password.system);
        $(e.currentTarget).find('input[name="login"]').val(response.password.login);
        $(e.currentTarget).find('input[name="password"]').val(response.password.password);
        $(e.currentTarget).find('textarea[name="notes"]').val(response.password.notes);
        $(e.currentTarget).find('input[name="id"]').val(Id);

        CKEDITOR.replace( 'edit_password_notes', {
               filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
               filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
           });

         },"json"
        );
});

$( ".update_knowledge_pass" ).click(function() {
  for ( instance in CKEDITOR.instances )
          CKEDITOR.instances[instance].updateElement();
  $.ajax({
         url: "{{ URL::route('admin.knowledge.update.password')}}",
         //headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',
         data: $('#update_password').serialize(),
         success: function(response){
         if(response.success)
         {
               $( "#close_edit_knowledge_pass" ).trigger( "click" );
               $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#passwords');
             var  table = $('#knowledge_pass_dt_table').DataTable( {
                     retrieve: true

                 } );

                 table.draw();
            $('#knowledge_pass_dt_table_wrapper').addClass('padding-top-40');
            alert_hide();
         }

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
         $('#err_edit_passwords').html(html_error);

       }
     });

   });
@endsection
