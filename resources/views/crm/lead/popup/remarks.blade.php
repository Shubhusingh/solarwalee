 <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('/lead/remarksupdate')}}" method="post">
            @csrf
        <input type="hidden" value={{$id}} name="id" >

  
  <textarea id="w3review" name="remark" rows="4" cols="20" class="form-control">
</textarea>
<br>

        <input type="submit" class="btn btn-primary" value="Update" style="float: inline-end;
    background-color: #c23321;"> 

        </div>
      
      
        </form>
    </div>
  </div>