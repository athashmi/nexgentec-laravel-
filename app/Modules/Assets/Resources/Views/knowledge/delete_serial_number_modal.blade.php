<div class="modal fade" id="modal-delete-serial-number" tabIndex="-1">
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
          Are you sure you want to delete this Record?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
        
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="serial_number_id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_delete_knowledge_serial_number">Close</button>
          <button type="submit" class="btn btn-danger" id="del_serial_number">
            <i class="fa fa-times-circle" ></i> Yes
          </button>
         
      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent
      $('#modal-delete-serial-number').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="serial_number_id"]').val(Id);
      });
 


      $("#del_serial_number").click(function() {
        
          var Id = $('input[name="serial_number_id"]').val();

           $.get('/admin/knowledge/delete/serial_number/'+Id,function( response ) {

            $( "#close_delete_knowledge_serial_number" ).trigger( "click" );

             
          
            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#serial_numbers');

             var  table = $('#knowledge_serial_numbers_dt_table').DataTable({
                     retrieve: true

                 });

            table.draw();
            $('#knowledge_serial_numbers_dt_table_wrapper').addClass('padding-top-40');
             
                                    
                                  },"json" 
                );
             alert_hide();
             
                
              });


@endsection
