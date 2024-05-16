 <div class="modal-content">
      <div class="modal-header" style="background-color: #c23321;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:#fff">Order Lost</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <form action="{{url('/lead/interest/store2')}}" method="post">
                                      @csrf
                                  <input type="hidden" value="{{$id}}"  name="id"/>
                                  <select class="form-control" name='update'>
                                      <option>Price</option>
                                      <option>Technical Capability</option>
                                      <option>Local Customer Reference</option>
                                      <option>Loose Follow Up</option>
                                      <option>Brand Not Available</option>
                                      <option>Product Not Available</option>
                                      <option>Customer Cancel The Plan</option>
                                      
                                  </select>
                              <br>
                                
  <textarea id="w3review" name="remark" rows="4" cols="20" class="form-control">
</textarea>
<br>
                                  
                                  <input type="submit" value="Update" class="btn btn-danger"/>
                                  </form>
        
        
    </div>
  </div>