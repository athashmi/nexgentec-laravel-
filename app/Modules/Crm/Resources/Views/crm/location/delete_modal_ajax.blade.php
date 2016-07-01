
<div class="modal fade" id="modal-delete-loc" tabIndex="-1">
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
         
         <input type="hidden" name="del_id_loc" value="">
        
       
         <input type="hidden" name="cust_id_loc_del" value="">
          <button type="button" class="btn btn-default del" id="del_id_loc_no" 
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" id="del_id_loc">
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
      $('#modal-delete-loc').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        
          var cust_id = $(e.relatedTarget).data('custid');
        //populate the textbox
        $(e.currentTarget).find('input[name="del_id_loc"]').val(Id);
     
        $(e.currentTarget).find('input[name="cust_id_loc_del"]').val(cust_id);
      });




      $("#del_id_loc").click(function() {
          //alert( "Handler for .click() called." );
          var Id = $('input[name="del_id_loc"]').val();
        

           //var loc_id = $('input[name="del_id_loc"]').val();
          var customer_id = $('input[name="cust_id_loc_del"]').val();

           $.get('/admin/crm/ajax_del_location/'+Id+'/'+customer_id,function( response ) {

           $('#locations_tbl').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
              $('#locations_tbl').html(response.html_content);

                ///$('#loc_contacts_'+loc_id).html(data_response);
                                    
                                  },"json" 
                );
                $( "#del_id_loc_no" ).trigger( "click" );
                 alert_hide(); 
                
              });

    });
  </script>
@endsection
