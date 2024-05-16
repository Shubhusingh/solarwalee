  <style>





.btn {
	background-color: var(--fg);
	border-radius: 0.25em;
	color: var(--bg);
	cursor: pointer;
	padding: 0.375em 0.75em;
	transition:
		background-color calc(var(--trans-dur) / 2) linear,
		color var(--trans-dur);
	-webkit-tap-highlight-color: transparent;
}
.btn:hover {
	background-color: hsl(var(--hue),10%,50%);
}
.btn-group {
	display: flex;
	gap: 0.375em;
	margin-bottom: 1.5em;
}
.timeline {
	margin: auto;
	padding: 0 1.5em;
	width: 100%;
	max-width: 36em;
}
.timeline__arrow {
	background-color: transparent;
	border-radius: 0.25em;
	cursor: pointer;
	flex-shrink: 0;
	margin-inline-end: 0.25em;
	outline: transparent;
	width: 2em;
	height: 2em;
	transition:
		background-color calc(var(--trans-dur) / 2) linear,
		color var(--trans-dur);
	-webkit-appearance: none;
	appearance: none;
	-webkit-tap-highlight-color: transparent;
}
.timeline__arrow:focus-visible,
.timeline__arrow:hover {
	background-color: hsl(var(--hue),10%,50%,0.4);
}
.timeline__arrow-icon {
	display: block;
	pointer-events: none;
	transform: rotate(-90deg);
	transition: transform var(--trans-dur) var(--trans-timing);
	width: 100%;
	height: auto;
}
.timeline__date {
	font-size: 0.833em;
	line-height: 2.4;
}
.timeline__dot {
	
	border-radius: 50%;
	display: inline-block;
	flex-shrink: 0;
	margin: 0.625em 0;
	margin-inline-end: 1em;
	position: relative;
	width: 0.75em;
	height: 0.75em;
}
.timeline__item {
	position: relative;

}
.timeline__item:not(:last-child):before {

	content: "";
	display: block;
	position: absolute;
	top: 1em;
	left: 2.625em;
	width: 0.125em;
	height: 100%;
	transform: translateX(-50%);
}
[dir="rtl"] .timeline__arrow-icon {
	transform: rotate(90deg);
}
[dir="rtl"] .timeline__item:not(:last-child):before {
	right: 2.625em;
	left: auto;
	transform: translateX(50%);
}
.timeline__item-header {
	display: flex;
}
.timeline__item-body {
	border-radius: 0.375em;
	overflow: hidden;
	margin-top: 0.5em;
	margin-inline-start: 4em;
	height: 0;
}
.timeline__item-body-content {
	background-color: hsl(var(--hue),10%,50%,0.2);
	opacity: 0;
	padding: 0.5em 0.75em;
	visibility: hidden;
	transition:
		opacity var(--trans-dur) var(--trans-timing),
		visibility var(--trans-dur) steps(1,end);
}
.timeline__meta {
	width: 100%;
}
.timeline__title {
	font-size:15px;
	line-height: 1;
	color:'#32323cc7';
}
/* Expanded state */
.timeline__item-body--expanded {
	height: auto;
}
.timeline__item-body--expanded .timeline__item-body-content {
	opacity: 1;
	visibility: visible;
	transition-delay: var(--trans-dur), 0s;
}
.timeline__arrow[aria-expanded="true"] .timeline__arrow-icon {
	transform: rotate(0);
}

/* Dark theme */

  </style>
  
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Timeline</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    <svg display="none">
	<symbol id="arrow">
		<polyline points="7 10,12 15,17 10" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
	</symbol>
</svg>

<div id="timeline" class="timeline">
    

    
@foreach ($tracking as $value)
	
	<div class="timeline__item">
		<div class="timeline__item-header">
			<button class="timeline__arrow" type="button" id="item1" aria-labelledby="item1-name" aria-expanded="false" aria-controls="item1-ctrld" aria-haspopup="true" data-item="1">
				<svg class="timeline__arrow-icon" viewBox="0 0 24 24" width="24px" height="15px">
					<use href="#arrow" />
				</svg>
			</button>
		
			<span id="item1-name" class="timeline__meta">
				<time class="timeline__date" datetime="1970-01-01">{{\Carbon\Carbon::parse($value->created_at)->format('d-m-Y')}}  {{$value->current_time ?? ''}}</time><br>
				<strong class="timeline__title">{{$value->acvitiy ?? ''}}</strong>
			</span>
		</div>
		<br>
		
		@if(!empty($value->date))
					<p style="margin-left: 20px;margin-top: -17px">{{$value->date ?? ''}}    {{$value->time ?? ''}}</p>

		
		@else
		
		
		
		@endif
					@if(!empty($value->remarks))
		<p style="margin-left: 20px;margin-top: -17px">{{$value->remarks ?? ''}}</p>
		@endif
		
		@php
		$user=DB::table('users')->where('id',$value->user_id)->first();
		@endphp
	<p style="margin-left: 40px;margin-top: -17px;font-size:12px">	<i class="fas fa-user-check"></i> by {{$user->name ?? ''}}</p>
	</div>
	
	@endforeach

</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>