<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
         
                <span>@lang('Lead Status')</span>
           
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="las la-times"></i>
        </button>
    </div>
    <form action="{{url('admin/loan/update/store')}}" method="POST">
        @csrf
        <div class="modal-body">

            <input name="id" value="{{$id}}" type="hidden" />
    
     
            <div class="form-group">
                <label>@lang('Lead Status')</label>
                <select name="leadstatus" class="form-control" required>
                    <option value="2">No Answer Leads</option>
                     <option value="3">Fresh Leads</option>
                      <option value="4">Interested Leads</option>
                       <option value="5">Less Salary</option>
                        <option value="6">Not Eligible</option>
                         <option value="7">Docs Received</option>
                         
                         <option value="8">Incomplete Docs</option>
                         
                          <option value="9"> PayDay Loan Pending</option>
                       
                </select>
            </div>

                <div class="form-group">
                    <label>@lang('Remarks')</label>
                    <textarea class="form-control" name="reason" rows="4" ></textarea>
                </div>
         
        </div>
        <div class="modal-footer">
         
                <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
        
              
         
        </div>
    </form>
</div>