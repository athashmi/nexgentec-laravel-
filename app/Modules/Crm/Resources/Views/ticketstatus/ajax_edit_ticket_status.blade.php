<div class="modal fade" id="modal-edit-ticket-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Edit Ticket Status</h4>
      </div>
      <div class="modal-body">               
          <div id="err_status_update">
          </div>    
        <form id="edit_ticket_status">                 
          <div class="form-group">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"title",'class'=>"form-control"]) !!}
              <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
              <input type="hidden" name="status_id" value="">
          </div>
          
          <div class="form-group">
              <label>Color</label>
              <div class="input-group " id="colorpicker">
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
                  data-dismiss="modal" id="close_edit_ticket_status">Close</button>
          <button  class="btn btn-primary update_ticket_status">
             Update
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('script')
@parent
<script src="/colorpicker/bootstrap-colorpicker.min.js"></script>

@endsection

@section('document.ready')
@parent
      $('#modal-edit-ticket-status').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
      
        $(e.currentTarget).find('input[name="status_id"]').val(id);
        $.get('/admin/crm/ticketstatus/edit/'+id,function(response ) {
                
                $(e.currentTarget).find('input[name="status_id"]').val(id);
                $(e.currentTarget).find('input[name="title"]').val(response.status.title);
                $(e.currentTarget).find('input[name="color_code"]').val(response.status.color_code); 

                $("#colorpicker").colorpicker({
                      color:response.status.color_code,
                      format:'hex',
                  });  
                
                 // $(".colorpicker").colorpicker('update');                                                          
                },"json" 
              );
          });
       
     

       $( ".update_ticket_status" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.ticket.status.update')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#edit_ticket_status').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_edit_ticket_status" ).trigger( "click" );
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
                $('#err_status_update').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

@endsection
@section('styles')
 @parent  
    <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/>
   
@endsection