               <div class="box-body table-responsive">

                 <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-ticket-status" class="btn btn-primary pull-right"> Create New Status</button>
                  <table class="table table-hover" id="dt_table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Color</th>
                        <th>Created on</th>
                        <th>Actions</th>
                      </tr>
                    </thead>

                    <tbody>
                            @foreach ($statuses as $status)
                            
                            
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td>{{ $status->title }}</td>
                                
                                <td>
                                  <div class="color-palette-set">
                                    <div class="color-palette" style="background-color:{{ $status->color_code }}"><span>&nbsp;</span></div>
                                  </div>
                                </td>
                                <td>{{ date($global_date,strtotime($status->created_at)) }}</td>
                                <td>
                                        
                                       
                                         <button type="button" class="btn btn-sm btn-primary"
                                              data-toggle="modal" data-id="{{$status->id}}" id="modaal" data-target="#modal-edit-ticket-status">
                                        <i class="fa fa-pencil"></i> Edit
                                      </button>
                                        <!-- <button type="submit" class="btn btn-xs btn-danger">Delete</button> -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                              data-toggle="modal" data-id="{{$status->id}}" id="modaal" data-target="#modal-delete-ticket-status">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                      </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                  </table>
                  <div class="col-xs-12">
                  </div>

                </div><!-- /.box-body -->
           
            

 @include('crm::ticket.delete_modal')

@section('script')
<script src="/js/jquery.dataTables.min.js"></script> 

@endsection
@section('document.ready')
@parent
      $('.pagination').addClass('pull-right');
    

@endsection
@section('styles')
 
 <style>
 .bot_10px{
        margin-bottom: 10px;
    }

 </style>
@endsection