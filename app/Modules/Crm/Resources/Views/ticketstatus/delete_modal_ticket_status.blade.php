<div class="modal fade" id="modal-delete-ticket-status" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          Are you sure you want to delete ticket status?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_del_ticket_status">Close</button>
          <button  class="btn btn-danger del_ticket_status">
            <i class="fa fa-times-circle"></i> Yes
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
      $('#modal-delete-ticket-status').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
      
        $(e.currentTarget).find('input[name="status_id"]').val(id);
       
      });

       $( ".del_ticket_status" ).click(function() {

        var id = $('input[name="status_id"]').val();
      
        $.get('/admin/crm/ticketstatus/delete_ticket_status/'+id,function(response ) {
                
               $( "#close_del_ticket_status" ).trigger( "click" );
             $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#ticket_statuses');
             


               $.get('{{ URL::route("admin.tickets.status.list")}}',function(response) {
                $('#ticket_statuses').html(response);
                   },"html" 
                    );
               alert_hide(); 
         
                                                                
                },"json" 
              );
          });
@endsection
