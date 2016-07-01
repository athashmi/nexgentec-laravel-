 <div class="box-body table-responsive">
  
      <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-service-item" class="btn btn-primary pull-right">  Create New Service Item</button>
      <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Created at</th>
                 
                <th>Actions</th>
            </tr>
        </thead>
       <tbody>
            @foreach ($service_items as $service_item)
            
            
            <tr>
                <td>{{ $service_item->title }}</td>
                <td>{{ date($global_date,strtotime($service_item->created_at)) }}</td>
                <td>
                       
                 <button type="button" class="btn btn-danger btn-sm"
                      data-toggle="modal" data-id="{{$service_item->id}}" id="modaal" data-target="#modal-delete-service-item">
                        <i class="fa fa-times-circle"></i>
                        Delete
                    </button>
               
                </td>
            </tr>
            @endforeach
        </tbody>    
    </table>
      <div class="clearfix"></div>
 </div>


  