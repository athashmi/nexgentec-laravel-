<div class="modal fade" id="modal-create-knowledge-procedure" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Create Procedure</h4>
      </div>
      <div class="modal-body">
          <div id="err_procedure">
          </div>
        <form id="create_procedure">
            <div class="form-group col-lg-12">
                <label>Customer</label>
                 <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                                    $selected_cust = session('cust_id');
                                  else
                                    $selected_cust = '';
                            ?>
                
                {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer'])!!}

            </div>

            <div class="form-group col-lg-12">
                <label>Title</label>
                {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}

            </div>
            
            <div class="form-group col-lg-12">
  	            <label>Procedure</label>
  	            {!! Form::textarea('procedure',null, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'procedure','rows'=>10]) !!}
  	        </div>
        </form>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->


          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_knowledge_procedure">Close</button>
          <button  class="btn btn-primary new_knowledge_procedure">
             Save
          </button>

      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent

      $('#modal-create-knowledge-procedure').on('show.bs.modal', function(e)
      {
          $('#err_procedure').html('');
       });

       $( ".new_knowledge_procedure" ).click(function() {
         for ( instance in CKEDITOR.instances )
                 CKEDITOR.instances[instance].updateElement();
         $.ajax({
                url: "{{ URL::route('admin.knowledge.store.procedure')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_procedure').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_knowledge_procedure" ).trigger( "click" );
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
                $('#err_procedure').html(html_error);

              }
            });

          });

@endsection
