
<div class="modal fade" id="modal-edit-contact" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Update Contact</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="cntct_msg_div" style="display:none">
              <ul id="cntct_errors">
              </ul>
          </div>
         <form id="cntct_form">
         <input type="hidden" name="cntct_id" value="">
         <input type="hidden" name="customer_id" value="">
        <div class="form-group col-lg-6">
            <label>Location</label>
             <?php $location_index = [];?>
               {!! Form::select('location_index', $location_index,'',['class'=>'form-control multiselect','id'=>'cnt_location'])!!}
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
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_cntct"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_contact">
            Update
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
  
      $('#modal-edit-contact').on('show.bs.modal', function(e) 
      {
        var Id = $(e.relatedTarget).data('id');
        var CustId = $(e.relatedTarget).data('custid');

        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.load_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'cntct_id='+Id+'&customer_id='+CustId,
          success: function(response){
             //console.log(response.locations.length);
         //console.log(response.contact.customer_location_id);
              if(response.locations.length>0) 
            {
              $('#cnt_location').html('');
                $.each(response.locations,function(index, location_data) {  
                        //console.log(location_data); 
                    $('#cnt_location').append($("<option></option>")
                             .attr("value",location_data.id)
                             .text( location_data.location_name));         
                });
                $('#cnt_location').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });

                $('#cnt_location').multiselect('rebuild');

                $('option[value="'+response.contact.customer_location_id+'"]', $('#cnt_location')).prop('selected', true);

                $('#cnt_location').multiselect('refresh');
              
                
            }

            $(e.currentTarget).find('input[name="cntct_id"]').val(Id);
            $(e.currentTarget).find('input[name="customer_id"]').val(CustId);
            $(e.currentTarget).find('input[name="f_name"]').val(response.contact.f_name);
            $(e.currentTarget).find('input[name="l_name"]').val(response.contact.l_name);
            $(e.currentTarget).find('input[name="title"]').val(response.contact.title);
            $(e.currentTarget).find('input[name="email"]').val(response.contact.email);
            $(e.currentTarget).find('input[name="contact_phone"]').val(response.contact.phone);
            $(e.currentTarget).find('input[name="contact_mobile"]').val(response.contact.mobile);
            (response.contact.is_poc==1) ? $("#chk_poc").prop('checked',true):$("#chk_poc").prop('checked',false); 
            //$(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
          }
        });  

      
      });
         

         $( ".update_ajax_contact" ).click(function() {
        //alert( "Handler for .click() called." );
         var Id = $('input[name="cntct_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_contact')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#cntct_form').serialize() ,
          success: function(response){
            if(response.success){
              //var loc_id= $('#cnt_location').val();
              var customer_id = $('input[name="customer_id"]').val();
              //$('#cntct_errors').html(response.success);
             // $('#cntct_msg_div').removeClass('alert-danger').addClass('alert-success').show();
              $( "#close_modal_cntct" ).trigger( "click" );
              //$('#loc_tbl_'+$('#cnt_location').val()).html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');


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
        $('#cntct_errors').html(html_error);
        $('#cntct_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });
  
        });
    
  </script>
@endsection