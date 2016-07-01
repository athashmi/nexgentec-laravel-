<div class="modal fade" id="modal-create-rate" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Create New Rate</h4>
      </div>
      <div class="modal-body">               
          <div id="err_rate">
          </div>    
        <form id="create_rate">                 
         <div class="form-group col-lg-6">
              <label>Title</label>
              {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
          </div>
      
         

          
          <div class="form-group col-lg-6">
              <label>Amount</label>
              {!! Form::input('text','amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
          </div>
       
        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
      
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_create_rate">Close</button>
          <button  class="btn btn-primary new_rate">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-create-rate').on('show.bs.modal', function(e) 
      {

          $('#err_rate').html('');

      });

       $( ".new_rate" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.crm.default_rate.store')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_rate').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_create_rate" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_rates');
                     
                      $.get('{{URL::route("admin.crm.default_rates")}}',function(response ) {
                        $('#tab_rates').html(response);
                           },"html" 
                            );
                   alert_hide(); 
                }
                
                },
                error: function(data){
                    var errors = data.responseJSON;
                    //console.log(errors);
                    var html_error = '<div  class="alert alert-danger"><ul>';
                    $.each(errors, function (key, value) 
                    {
                        html_error +='<li>'+value+'</li>';
                    })
                     html_error += "</ul></div>";
                $('#err_rate').html(html_error);
               
              }
            });
      
          });

   
@endsection
