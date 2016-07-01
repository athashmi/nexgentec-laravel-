<div class="modal fade" id="modal-create-service-item" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create service item</h4>
      </div>
      <div class="modal-body">               
          <div id="err_service_item">
          </div>    
        <form id="create_service_item">
                  
                    <div class="col-lg-12"> 

                        <div class="form-group col-lg-6">
                            <label>Title</label>
                            {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                        </div>
                  
                   
                         <div class="form-group col-lg-6">
                            <label>Description</label>
                            {!! Form::input('text','description',null, ['placeholder'=>"Description",'class'=>"form-control"]) !!}
                        </div>
                    </div>
                    
                          
                    
               
           </form>
           <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_service_item">Close</button>
          <button  class="btn btn-primary new_service_item">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
$('#modal-create-service-item').on('show.bs.modal', function(e) 
      {

          $('#err_status').html('');

      });

       $( ".new_service_item" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.service_item.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_service_item').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_service_item" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_service_items');
                     
                   $.get('{{URL::route("admin.service_item.index")}}',function(response ) {
                        $('#tab_service_items').html(response);
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
                $('#err_service_item').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

   
@endsection

