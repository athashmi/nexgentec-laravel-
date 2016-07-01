         <div class="box-body table-responsive">

          <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-billing" class="btn btn-primary pull-right">Create New Billing Period</button>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created at</th>
                         
                        <th>Actions</th>
                    </tr>
                </thead>
               <tbody>
                    @foreach ($billing_periods as $billing_period)
                    
                    
                    <tr>
                        <td>{{ $billing_period->title }}</td>
                        <td>{{ date('d/m/Y',strtotime($billing_period->created_at)) }}</td>
                        <td>
                               
                         <button type="button" class="btn btn-danger btn-sm"
                              data-toggle="modal" data-id="{{$billing_period->id}}" id="modaal" data-target="#modal-delete-billing">
                                <i class="fa fa-times-circle"></i>
                                Delete
                            </button>
                       
                        </td>
                    </tr>
                    @endforeach
                </tbody>    
            </table>
         </div>
            
