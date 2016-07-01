<h3 class="profile-username text-center">Customer Scince</h3>
    <p class="text-muted text-center">{{ date('d/m/Y',strtotime($customer->customer_since)) }}</p>
    <ul class="list-group list-group-unbordered" >
        <li class="list-group-item">
          <b>Email Domain</b> <a class="pull-right">{{ $customer->email_domain}}</a>
        </li>
        <li class="list-group-item">
          <b>Main Phone</b> <a class="pull-right">{{$customer->main_phone}}</a>
        </li>
        <li class="list-group-item">
          <b>Active ? </b> <a class="pull-right">@if($customer->is_active)
                                                     <span class="badge btn-success">Yes</span>
                                                @else
                                                    <span class="badge">No</span>
                                                @endif 
                        </a>
        </li>
        <li class="list-group-item">
          <b>Taxable ? </b> <a class="pull-right">@if($customer->is_taxable)
                                                     <span class="badge btn-success">Yes</span>
                                                @else
                                                    <span class="badge">No</span>
                                                @endif 
                        </a>
        </li>
</ul>