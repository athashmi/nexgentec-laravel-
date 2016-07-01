
<div class="modal fade" id="modal-edit-location" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Update Location</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger"  id="loc_msg_div" style="display:none">
              <ul id="loc_errors">
              </ul>
          </div>
         <form id="loc_form">
         <input type="hidden" name="loc_id" value="">
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

             {!! Form::select('country', $countries,'',['class'=>'form-control multiselect','id'=>'cntry_edit','placeholder' => 'Pick a Country'])!!}
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
      
         
        
          <button type="button" class="btn btn-default" id="close_modal_edit_loc"
                  data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary update_ajax_location">
            Update
          </button>
         
      </div>

    </div>
  </div>
</div>
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
@parent
  <script type="text/javascript">
    $(document).ready(function() 
    {
       $(".dt_mask").inputmask();
      $('#modal-edit-location').on('show.bs.modal', function(e) 
      {
        var Id = $(e.relatedTarget).data('id');

        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.load_location')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: 'id='+Id,
          success: function(response){
              //console.log(response);
              //alert(response.location_name);
            $(e.currentTarget).find('input[name="loc_id"]').val(Id);
            $(e.currentTarget).find('input[name="location_name"]').val(response.location_name);
            $(e.currentTarget).find('input[name="address"]').val(response.address);
            $('option[value="'+response.country+'"]', $('#cntry_edit')).prop('selected', true);

                 $('#cntry_edit').multiselect('refresh');
            //$(e.currentTarget).find('input[name="country"]').val(response.country);
            $(e.currentTarget).find('input[name="city"]').val(response.city);
            $(e.currentTarget).find('input[name="zip"]').val(response.zip);
            $(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
            (response.default==1) ? $(e.currentTarget).find('input[name="default"]').prop('checked',true):$(e.currentTarget).find('input[name="default"]').prop('checked',false);
            //$(e.currentTarget).find('input[name="loc_main_phone"]').val(response.phone);
          }
        });  

      
      });

      $( ".update_ajax_location" ).click(function() {

        $('#loc_tbl_'+Id).html('<img id="load_img" src="{{asset('img/loader.gif')}}"  />');
        //alert( "Handler for .click() called." );
         var Id = $('input[name="loc_id"]').val();
        $.ajax({
          url: "{{ URL::route('admin.crm.ajax.update_location')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data:$('#loc_form').serialize() ,
          success: function(response){
            if(response.success){

               $( "#close_modal_edit_loc" ).trigger( "click" );
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
        $('#loc_errors').html(html_error);
        $('#loc_msg_div').removeClass('alert-success').addClass('alert-danger').show();
         alert_hide(); 
        // Render the errors with js ...
      }
        });  
      });

      
    });
  </script>
@endsection