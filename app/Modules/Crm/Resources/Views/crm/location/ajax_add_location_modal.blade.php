
<div class="modal fade" id="modal-add-new-location" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Add Location</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="loc_msg_div_new" style="display:none">
              <ul id="loc_errors_new">
              </ul>
          </div>
         <form id="new_loc_form">
         
         <input type="hidden" name="new_loc_customer_id" value="">
        <div class="form-group col-lg-6">
            <label>Location name</label>
            {!! Form::input('text','location_name',null, ['placeholder'=>"Location Name",'class'=>"form-control",'id'=>'location_name']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label>Address</label>
            {!! Form::input('text','address',null, ['placeholder'=>"Address",'class'=>"form-control",'id'=>'address']) !!}
        </div>
         <div class="form-group col-lg-6">
            <label>Country</label>
           {{--  {!! Form::input('text','country',null, ['placeholder'=>"Country",'class'=>"form-control",'id'=>'country']) !!} --}}

             {!! Form::select('country', $countries,'',['class'=>'form-control multiselect','id'=>'cntry_add','placeholder' => 'Pick a Country'])!!}
        </div>

        <div class="form-group col-lg-6">
            <label>State</label>
            {!! Form::input('text','state',null, ['placeholder'=>"State",'class'=>"form-control",'id'=>'state']) !!}
             
        </div>
        <div class="form-group col-lg-6">
            <label>City</label>
            {!! Form::input('text','city',null, ['placeholder'=>"City",'class'=>"form-control" ,'id'=>'city']) !!}
        </div>
        <div class="form-group col-lg-6">
            <label>Zip</label>
            {!! Form::input('text','zip',null, ['placeholder'=>"Zip",'class'=>"form-control" ,'id'=>'zip']) !!}
        </div>

        <div class="form-group col-lg-6">
            <label>Main Phone</label>
            {!! Form::input('text','loc_main_phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'id'=>'loc_main_phone','data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
        </div>

        <div class="form-group col-lg-6">
                            <label class="radio-inline">{!! Form::checkbox('default', 1,'',['id'=>'default']); !!}</label>
                            <label>Default Location?</label>
                    </div>
        <div style="clear:both"></div>
        </form>
      </div>
      <div class="modal-footer">
      
         
        
          <button type="button" class="btn btn-default close_modal" id="close_modal"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary add_ajax_location">
            Add
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
       
      $('#modal-add-new-location').on('show.bs.modal', function(e) 
      {
        var CustId = $(e.relatedTarget).data('id');
        $('input[name="new_loc_customer_id"]').val(CustId);

        
      });

      $( ".add_ajax_location" ).click(function() {

        //$('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}"  />');
        //alert( "Handler for .click() called." );
         //var CustId = $('input[name="loc_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.add_location')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#new_loc_form').serialize() ,
          success: function(response){
            if(response.success){
              
              //$('#loc_errors').html(response.success);
             // $('#loc_msg_div').removeClass('alert-danger').addClass('alert-success').show();
              $( ".close_modal" ).trigger( "click" );
              $('#locations_tbl').parent().before('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
              $('#locations_tbl').html(response.html_content);

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
        $('#loc_errors_new').html(html_error);
        $('#loc_msg_div_new').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });

      
    });
  </script>
@endsection