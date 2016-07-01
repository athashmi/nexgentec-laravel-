@foreach($locations as $location)

<tr id="location_{{$location->id}}">
	<td width="50">{{$location->location_name}}</td>
	<td style="width: 150px; text-align:left;">{{$location->address}}</td>

	 <td style="width: 100px"> <i class="fa fa-globe"></i>  {{$location->country}}</td>
	<td style="width: 100px"> <i class="fa fa-phone"></i>  {{$location->phone}}</td>


	    <td width="22">  <a class="pull-left" href="javascript:;" data-target="#modal-edit-location" id="modaal" data-id="{{$location->id}}"
	                                 data-toggle="modal"><i class="fa fa-pencil"></i></a>
	       <a class="pull-right" href="javascript:;" data-target="#modal-delete-loc" id="modaal" data-custid="{{$customer_id}}" data-id="{{$location->id}}" data-toggle="modal"> <i class="fa fa-times-circle"></i></a>                          
	    </td>
	
</tr>



@endforeach