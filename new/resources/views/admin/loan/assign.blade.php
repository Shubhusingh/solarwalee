<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
         
                <span>@lang('Lead Assign')</span>
           
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="las la-times"></i>
        </button>
    </div>
    <form action="{{url('admin/loan/assign')}}" method="POST">
        @csrf
        <div class="modal-body">

            <input name="id" value="{{$id}}" type="hidden" />
                @php
                 $user=DB::table('admins')->get();
                @endphp
                <div class="form-group">
                <label>@lang('Lead Assign')</label>
                <select name="leadstatus" class="form-control" required>
                    <option > Select Lead Person</option>
                    @foreach($user as $key => $value)
                    <option value="{{$value->id}}">{{ucfirst($value->name ?? '')}}</option>

                    @endforeach
                     </select>
            </div>

               
         
        </div>
        <div class="modal-footer">
         
                <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
        
              
         
        </div>
    </form>
</div>