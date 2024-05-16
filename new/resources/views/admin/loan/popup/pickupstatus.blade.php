 <div class="modal-content">
      <div class="modal-header" style="background-color: #c23321;">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <i class="las la-times"></i>
      </button>
      </div>
      <div class="modal-body">
     <form action="{{url('admin/lead/interest/store2')}}" method="post">
            @csrf
        <input type="hidden" value={{$id}} name="id" >
 <input type="radio" name="vehicle3" value="Not Pickup">
  <label for="radio">Not Pickup</label>
  
  
    <input type="radio"  name="vehicle3" value="Not Reachable">
  <label for="radio"> Not Reachable</label>
  
   <input type="radio" name="vehicle3" value="Not Available">
  <label for="radio">Not Available</label>
  
 
  <br><br>
  <input type="submit" class="btn btn-primary" value="Update" style="float: inline-end;
    background-color: #c23321;"> 
</div>
      
      
       
        </form>
    </div>
  </div>