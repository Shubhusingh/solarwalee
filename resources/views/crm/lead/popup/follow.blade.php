 <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Follow Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{url('/lead/interest/store4')}}" method="post">
            @csrf
             <input type="hidden" value={{$id}} name="id" >
  <label for="fname">Date *</label>
  <input type="date" class="form-control" id="date" name="date"><br>
  <label for="lname">Time:</label>
 <input type="time" class="form-control" id="time" name="time"><br>
 
  <textarea id="w3review" name="remark" rows="4" cols="50" class="form-control">

</textarea>
<br>
  <input type="submit" class="btn btn-primary" value="Update" style="float: inline-end;
    background-color: #c23321;">
</form>
      </div>
      
    </div>