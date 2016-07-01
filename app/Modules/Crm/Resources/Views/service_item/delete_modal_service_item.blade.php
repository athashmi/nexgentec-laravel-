<div class="modal fade" id="modal-delete-service-item" tabIndex="-1">
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
          Are you sure you want to delete Service item?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="service_item_id" value="">
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_del_service_item">Close</button>
          <button  class="btn btn-danger del_service_item">
            <i class="fa fa-times-circle"></i> Yes
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
      $('#modal-delete-service-item').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
      
        $(e.currentTarget).find('input[name="service_item_id"]').val(id);
       
      });

       $( ".del_service_item" ).click(function() {

        var id = $('input[name="service_item_id"]').val();
      
        $.get('/admin/crm/service/delete/'+id,function(response ) {
                
               $( "#close_del_service_item" ).trigger( "click" );
             $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_service_items');
             


              $.get('{{URL::route("admin.service_item.index")}}',function(response ) {
              $('#tab_service_items').html(response);
                 },"html" 
                  );
               alert_hide(); 
         
                                                                
                },"json" 
              );
          });
@endsection
