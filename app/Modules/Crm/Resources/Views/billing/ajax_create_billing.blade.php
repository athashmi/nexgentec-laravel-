<div class="modal fade" id="modal-create-billing" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Billing Period</h4>
      </div>
      <div class="modal-body">               
          <div id="err_billing">
          </div>    
        <form id="create_billing">                 
         <div class="form-group col-lg-6">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
          </div>
       
        
          
           <div class="form-group col-lg-6">
              <label>Description</label>
              {!! Form::input('text','description',null, ['placeholder'=>"Description",'class'=>"form-control"]) !!}
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_billing">Close</button>
          <button  class="btn btn-primary new_billing">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-create-billing').on('show.bs.modal', function(e) 
      {

          $('#err_billing').html('');

      });

       $( ".new_billing" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.billing.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_billing').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_billing" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_billing');
                     
                         $.get('{{URL::route("admin.billing.index")}}',function(response ) {
                            $('#tab_billing').html(response);
                               },"html" 
                        );

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
                $('#err_billing').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

   
@endsection
