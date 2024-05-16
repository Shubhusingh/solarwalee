 <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Not Interested</h5>
      

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <i class="las la-times"></i>
      </button>
      </div>
      <div class="modal-body">
        <form action="{{url('admin/lead/interest/store')}}" method="post">
            @csrf
        <input type="hidden" value={{$id}} name="id" >
<input type="radio"  name="vehicle3" value="Not Interested">
  <label for="radio"> Not Interested</label>
  
  <input type="radio"  name="vehicle3" value="Not Pickup">
  <label for="radio">Not Pickup</label>
  
  <input type="radio"  name="vehicle3" value="Not Reachable">
  <label for="radio">Not Reachable</label>
  
  
  <input type="radio"  name="vehicle3" value="Not Available">
  <label for="radio">Not Available</label>
  
  
  
  
    <input type="radio"  name="vehicle3" value="Wrong Number">
  <label for="radio">Wrong Number</label>
  
  <input type="radio" name="vehicle3" value="Cash On Delivery">
  <label for="radio">Cash On Delivery</label>
  <input type="radio"  name="vehicle3" value="Duplicate">
  <label for="radio"> Duplicate</label>
  
  


  <br>
  <textarea id="w3review" name="remark" rows="2" cols="20" class="form-control">
</textarea>
<br>

        <input type="submit" class="btn btn-primary" value="Update" style="float: inline-end;
    background-color: #c23321;"> 

        </div>
      
      
        </form>
    </div>
  </div>