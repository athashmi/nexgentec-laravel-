<div class="modal fade" id="modal-edit-knowledge-procedure" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Password</h4>
      </div>
      <div class="modal-body">
          <div id="err_edit_procedure">
          </div>
        <form id="update_procedure">
            <div class="form-group col-lg-12">
                <label>Customer</label>
                {!! Form::select('customer', $customers,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','id'=>'edit_procedure_customer'])!!}
                <input type="hidden" name="id" value="" >

            </div>

            <div class="form-group col-lg-12">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}

            </div>
            

            <div class="form-group col-lg-12">
  	            <label>Procedure</label>
  	            {!! Form::textarea('procedure',null, ['placeholder'=>"Procedure",'class'=>"form-control textarea",'id'=>'edit_procedure','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_edit_knowledge_procedure">Close</button>
          <button  class="btn btn-primary update_knowledge_procedure">
             Update
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-edit-knowledge-procedure').on('show.bs.modal', function(e)
{
  //get data-id attribute of the clicked element
  var Id = $(e.relatedTarget).data('id');
  //populate the textbox
  $.get('/admin/knowledge/edit/procedure/'+Id,function(response ) {

		if(response.procedure.customer)
    $('option[value="'+response.procedure.customer.id+'"]', $('#edit_procedure_customer')).prop('selected', true);

        $('#edit_procedure_customer').multiselect('refresh');

        $(e.currentTarget).find('input[name="title"]').val(response.procedure.title);
      
        $(e.currentTarget).find('textarea[name="procedure"]').val(response.procedure.procedure);
        $(e.currentTarget).find('input[name="id"]').val(Id);

        CKEDITOR.replace( 'edit_procedure', {
               filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
               filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
           });

         },"json"
        );
});

$( ".update_knowledge_procedure" ).click(function() {
  for ( instance in CKEDITOR.instances )
          CKEDITOR.instances[instance].updateElement();
  $.ajax({
         url: "{{ URL::route('admin.knowledge.update.procedure')}}",
         //headers: {'X-CSRF-TOKEN': token},
         type: 'POST',
         dataType: 'json',
         data: $('#update_procedure').serialize(),
         success: function(response){
         if(response.success)
         {
               $( "#close_edit_knowledge_procedure" ).trigger( "click" );
               $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#procedures');
             var  table = $('#knowledge_procedure_dt_table').DataTable( {
                     retrieve: true

                 } );

                 table.draw();
            $('#knowledge_procedure_dt_table_wrapper').addClass('padding-top-40');
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
         $('#err_edit_procedure').html(html_error);

       }
     });

   });
@endsection
