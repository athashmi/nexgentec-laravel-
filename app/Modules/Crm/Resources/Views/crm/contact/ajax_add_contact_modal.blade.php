
<div class="modal fade" id="modal-add-new-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Contact</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="cntct_msg_div_new" style="display:none">
              <ul id="cntct_errors_new">
              </ul>
          </div>
         <form id="new_cntct_form">
        
         <input type="hidden" name="new_contct_customer_id" value="">
        <div class="form-group col-lg-6">
            <label>Location</label>
             <?php $location_index = [];?>
               {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'new_cnt_location'])!!}
        </div>
        <div class="form-group col-lg-6">
          <label>First Name</label>
          {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
        </div>
        <div class="form-group col-lg-6">
          <label>Last Name</label>
          {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
        </div>

        <div class="form-group col-lg-6">
          <label>Title</label>
          {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
        </div>
        <div class="form-group col-lg-6">
          <label>Email</label>
          {!! Form::input('text','email',null, ['placeholder'=>"Email",'class'=>"form-control",'id'=>'cnt_email']) !!}
        </div>
        <div class="form-group col-lg-6">
          <label>Main Phone</label>
          {!! Form::input('text','contact_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
        </div>
        <div class="form-group col-lg-6">
          <label>Mobile Phone</label>
          {!! Form::input('text','contact_mobile',null, ['placeholder'=>"Mobile Phone",'class'=>"form-control"]) !!}
        </div>


        <div class="form-group col-lg-6">
          <label class="radio-inline">
            <input type="checkbox" id="chk_poc" name="primary_poc">
          </label>
          <label>Primary POC?</label>
        </div>

        <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_new_cntct"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_contact">
            Save
          </button>
         
      </div>

    </div>
  </div>
</div>
@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {

      $(".dt_mask").inputmask();
       
      $('#modal-add-new-contact').on('show.bs.modal', function(e) 
      {
        //var Id = $(e.relatedTarget).data('id');
        var CustId = $(e.relatedTarget).data('custid');
$('input[name="new_contct_customer_id"]').val(CustId);
         $.get('/admin/crm/ajax_get_locations_list/'+CustId,function( data_response ) {

                $('#new_cnt_location').html('');
                $.each(data_response.locations,function(index, location_data) {  
                        //console.log(location_data); 
                    $('#new_cnt_location').append($("<option></option>")
                             .attr("value",location_data.id)
                             .text( location_data.location_name)); 
                   
                });


                $('#new_cnt_location').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });
                $('#new_cnt_location').multiselect('rebuild');


                $('#new_cnt_location').multiselect('refresh');
              
                                  
                                },"json" 
              );
    
          
      
      });

      $( ".add_ajax_contact" ).click(function() {
        //alert( "Handler for .click() called." );
         //var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.add_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#new_cntct_form').serialize() ,
          success: function(response){
            if(response.success){
              //var loc_id= $('#new_cnt_location').val();
              var customer_id = $('input[name="new_contct_customer_id"]').val();
              //$('#cntct_errors').html(response.success);
             // $('#cntct_msg_div').removeClass('alert-danger').addClass('alert-success').show();
              $( "#close_modal_new_cntct" ).trigger( "click" );
              $('#loc_contacts').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

              //refresh location contacts
              $.get('/admin/crm/ajax_refresh_contacts/'+customer_id,function( data_response ) {
                                  $('#loc_contacts').html(data_response);
                                  
                                },"html" 
              );
              
               alert_hide(); 
              
            }
          },
          error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#cntct_errors_new').html(html_error);
        $('#cntct_msg_div_new').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });

      
    });
  </script>
@endsection