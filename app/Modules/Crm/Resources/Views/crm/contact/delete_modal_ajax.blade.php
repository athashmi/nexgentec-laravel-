
<div class="modal fade" id="modal-delete-cntct" tabIndex="-1">
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
      <?php //$route  = 'admin.'.$controller.'.destroy';?>
       <?php /* {!! Form::open(array('route' => array($route), 'method' => 'delete')) !!} */?>
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         
         <input type="hidden" name="del_id" value="">
         <input type="hidden" name="success_id" value="">
         <input type="hidden" name="method" value="">
         <input type="hidden" name="loc_id_cntct_del" value="">
         <input type="hidden" name="cust_id_cntct_del" value="">
          <button type="button" class="btn btn-default del"
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger delete_ajax">
            <i class="fa fa-times-circle"></i> Yes
          </button>
          
          <?php /*{!! Form::close() !!}*/?>
      </div>
    </div>
  </div>
</div>

@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
      $('#modal-delete-cntct').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
         var success_id = $(e.relatedTarget).data('successid');
         

           var loc_id = $(e.relatedTarget).data('locid');
          var cust_id = $(e.relatedTarget).data('custid');
        //populate the textbox
        $(e.currentTarget).find('input[name="del_id"]').val(Id);
        $(e.currentTarget).find('input[name="success_id"]').val(success_id);
    
         $(e.currentTarget).find('input[name="loc_id_cntct_del"]').val(loc_id);
        $(e.currentTarget).find('input[name="cust_id_cntct_del"]').val(cust_id);
      });




      $(".delete_ajax").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="del_id"]').val();
         
          var success_id = $('input[name="success_id"]').val();

           //var loc_id = $('input[name="loc_id_cntct_del"]').val();
          var customer_id = $('input[name="cust_id_cntct_del"]').val();

           $.get('/admin/crm/ajax_del_contact/'+Id,function( response ) {

              $('#loc_contacts').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

             $.get('/admin/crm/ajax_refresh_contacts/'+customer_id,function( data_response ) {
                                  $('#loc_contacts').html(data_response);
                                  
                                },"html" 
              );
                ///$('#loc_contacts_'+loc_id).html(data_response);
                                    
                                  },"json" 
                );
                $( ".del" ).trigger( "click" );
                 alert_hide(); 
                
              });

    });
  </script>
@endsection
