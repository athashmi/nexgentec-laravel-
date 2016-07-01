 <div class="box-body table-responsive">
 <a href="javascript:;" data-target="#modal-reset"  data-id="{{$zoho->id}}" data-toggle="modal" class="btn btn-sm btn-primary pull-right">Reset Auth Token</a>
   </div>
<div class="box-body table-responsive">
       

<form id="edit_zoho_form">      
    <div class="form-group col-lg-4">
        <label>Zoho Email</label>
        {!! Form::input('text','email',$zoho->email, ['placeholder'=>"Zoho Email",'class'=>"form-control"]) !!}
        <input type="hidden" name="zoho_id" value="{{ $zoho->id}}">
    </div>

     <div class="form-group col-lg-4">
        <label>Password</label>
        {!! Form::input('text','password',$zoho->password, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
    </div>

     <div class="form-group col-lg-4">
        <label>Auth Token</label>
        {!! Form::input('text','token',$zoho->auth_token, ['placeholder'=>"Auth token",'class'=>"form-control"]) !!}
    </div>
  
    
</form>


        <div class="form-group col-lg-2 pull-right">
            <button type="submit" class="btn btn-md btn-success btn-block edit_zoho">Update</button>
        </div>

   
<div class="clearfix"></div>
</div>
