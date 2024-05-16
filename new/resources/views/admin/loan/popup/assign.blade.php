 <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
            <form action="{{url('/lead/lead/assign')}}" method="post">
            @csrf
             <input type="hidden" value={{$id}} name="id" >
  <label for="fname">Assign User *</label>
  
  <select class="form-control" name="ownerid" >
        <option selected disabled>{{__('Select Lead Assign')}}</option>
       @foreach ($tracking as $lead)
      <option value={{$lead->id}}>
          
           {{$lead->name ?? ''}}
      </option>
      @endforeach
  </select>
 

</textarea>
<br>
  <input type="submit" class="btn btn-primary" value="Update" style="float: inline-end;
    background-color: #c23321;">
</form>
     
      </div>
   
    </div>