<div class="modal fade" id="modal-delete_rate" tabIndex="-1">
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
         <input type="hidden" name="rate_id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_delete_rate">Close</button>
          <button type="submit" class="btn btn-danger del_rate">
            <i class="fa fa-times-circle"></i> Yes
          </button>
      
      </div>
    </div>
  </div>
</div>
@section('document.ready')
@parent
      $('#modal-delete_rate').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="rate_id"]').val(Id);
      });

       $( ".del_rate" ).click(function() {
              var id = $('input[name="rate_id"]').val();
           $.get('/admin/crm/rate_delete/'+id,function(response ) {

             $( "#close_delete_rate" ).trigger( "click" );
             //console.log(response.success);
            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_rates');
                     
                      $.get('{{URL::route("admin.crm.default_rates")}}',function(response ) {
                        $('#tab_rates').html(response);
                           },"html" 
                            );
                   alert_hide(); 

           },'json');
         });

@endsection
