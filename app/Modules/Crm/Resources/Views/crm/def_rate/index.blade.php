 
  <div class="box-body table-responsive">

   <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-rate" class="btn btn-primary pull-right"> Create New Rate</button>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Amount</th>
        <th>Title</th>
       
        <th>Created at</th>
        
        <th>Actions</th>
      </tr>
      </thead>
       <tbody>
              @foreach ($rates as $rate)
              
              
              <tr>
              <td>{{ $rate->id }}</td>
                  <td>{{ $rate->amount }}</td>
                  <td>{{ $rate->title}}</td>
                  <td>{{ date($global_date,strtotime($rate->created_at)) }}</td>
                  <td>
                         
                   <button type="button" class="btn btn-danger btn-sm"
                      data-toggle="modal" data-id="{{$rate->id}}" id="modaal" data-target="#modal-delete_rate">
                        <i class="fa fa-times-circle"></i>
                        Delete
                    </button>
                 
                  </td>
              </tr>
              @endforeach
          </tbody>    
     
    </table>
    

  </div><!-- /.box-body -->
