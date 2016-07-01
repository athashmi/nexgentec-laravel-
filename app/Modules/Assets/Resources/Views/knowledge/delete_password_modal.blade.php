<div class="modal fade" id="modal-delete-pass" tabIndex="-1">
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
         <input type="hidden" name="pass_id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_delete_knowledge_pass">Close</button>
          <button type="submit" class="btn btn-danger" id="del_pass">
            <i class="fa fa-times-circle" ></i> Yes
          </button>
         
      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent
      $('#modal-delete-pass').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="pass_id"]').val(Id);
      });
 


      $("#del_pass").click(function() {
        
          var Id = $('input[name="pass_id"]').val();

           $.get('/admin/knowledge/delete/password/'+Id,function( response ) {

            $( "#close_delete_knowledge_pass" ).trigger( "click" );

             
            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#service_items_panel');
            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#passwords');

             var  table = $('#knowledge_pass_dt_table').DataTable({
                     retrieve: true

                 });

            table.draw();
            $('#knowledge_pass_dt_table_wrapper').addClass('padding-top-40');
             
                                    
                                  },"json" 
                );
             alert_hide();
             
                
              });


@endsection
