<style type="text/css">
	.navbar .row{ width: 100%; }
	.navbar div:nth-child(2){
		text-align: center; font-size: 22px; font-weight: bold; color: #FFF;
	}
	/*.navbar-brand{ font-size: 1.40rem !important; }*/
</style>
<nav class="navbar navbar-expand navbar-dark bg-dark static-top" style="padding: 1%;">
    {{-- <a class="navbar-brand mr-1" href="{{ config('app.url') }}">{{config('app.name')}}</a> --}}
    <div class="row">
    	<div class="col-sm-2">
    		<a href="{{config('app.url')}}">
    			<img src="{{asset('images/pnepallogo.png')}}" style="width: 120px;height: 100px">
    		</a>
			<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggleFront" href="#">
      		<i class="fas fa-bars"></i>
		</div>
		<div class="col-sm-8">
			Federal Parliament Secretariat,  Nepal<br>
			<span>संघीय संसद सचिवालय, सिंहदरवार, काठमाडौं, नेपाल</span>
		</div>
		<div class="col-sm-2">
			<img src="{{asset('images/flag.webp')}}" style="width: 70px; float: right;">
		</div>
    </div>
    </button>
</nav>
