<div class="modal fade" id="modal-create-ticket-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create Ticket Status</h4>
      </div>
      <div class="modal-body">               
          <div id="err_status">
          </div>    
        <form id="create_ticket_status">                 
          <div class="form-group">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"title",'class'=>"form-control"]) !!}
              <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
          </div>
          
          <div class="form-group">
              <label>Color</label>
              <div class="input-group colorpicker">
                {!! Form::input('text','color_code',null, ['placeholder'=>"color code",'class'=>"form-control"]) !!}
               <div class="input-group-addon"><i></i></div>
              </div>
          </div>
        </form>
        
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_ticket_status">Close</button>
          <button  class="btn btn-primary new_ticket_status">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-create-ticket-status').on('show.bs.modal', function(e) 
      {

          $('#err_status').html('');

      });

       $( ".new_ticket_status" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.ticket.status.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_ticket_status').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_ticket_status" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#ticket_statuses');
                     
                      $.get('{{ URL::route("admin.tickets.status.list")}}',function(response) {
                        $('#ticket_statuses').html(response);
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
                $('#err_status').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

   
@endsection
