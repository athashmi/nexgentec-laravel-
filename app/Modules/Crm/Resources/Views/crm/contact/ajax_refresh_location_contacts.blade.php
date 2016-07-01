
@foreach($customer->locations as $location)
    @foreach($location->contacts as $contact)

      <tr id="loc_contacts_{{$contact->id}}">
        <td width="50">{{$contact->f_name}} {{$contact->l_name}}</td>
        <td width="245" style="text-align:left;"> <i class="fa fa-envelope"></i> {{$contact->email}}</td>
          <td style="width: 150; text-align:left;"><i class="fa fa-phone"></i>  {{$contact->phone}} <br/>
          <i class="fa fa-mobile"></i>  {{$contact->mobile}}</td>
       
        <td style="width: 75">  {{$location->location_name}}</td>
        <td style="width:22"><a  class="pull-left" href="javascript:;" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
        <a class="pull-right" href="javascript:;"  data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$customer->id}}"  data-target="#modal-delete-cntct" data-toggle="modal" ><i class="fa fa-times-circle"></i></a></td>
      {{-- <td>
        <div class="progress progress-xs">
          <div style="width: 55%" class="progress-bar progress-bar-danger"></div>
        </div>
      </td>
      <td><span class="badge bg-red">55%</span></td> --}}
    </tr>
        {{-- <tr id="loc_contacts_{{$contact->id}}">
            <td>{{$contact->f_name}} {{$contact->l_name}}</td>
            <td style="width: 150px; text-align:center;"> <i class="fa fa-envelope"></i> {{$contact->email}}<br/>
             <i class="fa fa-phone"></i>  {{$contact->phone}} <br/>
              <i class="fa fa-mobile"></i>  {{$contact->mobile}}</td>
           
            <td style="width: 75px">  {{$location->location_name}}</td>
            <td><a  class="pull-left" href="javascript:;" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            <a class="pull-right" href="javascript:;"  data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$customer->id}}"  data-target="#modal-delete-cntct" data-toggle="modal" ><i class="fa fa-times-circle"></i></a></td>
        </tr> --}}
    @endforeach
@endforeach