 <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Status Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
         <form action="{{url('lead/lead_status')}}" method="post">
                                      @csrf
                                  <input type="hidden" value="{{$id}}"  name="id"/>
                                  <select class="form-control" name='update'>
                                      <option>Super Hot Lead</option>
                                      <option>Hot lead</option>
                                      <option>Won Lead</option>
                                      <option>Cold Lead</option>
                                      <option>Dead Lead</option>
                                      <option>Lost Lead</option>
                                      <option>Oder Booking</option>
                                       <option>Follow</option>
                                  </select>
                              <br>
                                  
                                  <input type="submit" value="Update" class="btn btn-danger"/>
                                  </form>
     
      </div>
   
    </div>