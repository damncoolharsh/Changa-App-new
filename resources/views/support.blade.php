@extends('layouts/main')


@section('content')
<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->


<!-- Start wrapper-->
<div id="wrapper">

 <div class="loader-wrapper">
  <div class="lds-ring">
	  <div class="card terms-view mx-auto my-5 h-full">
		  <div class="card-body">
        <div class="text-center pb-4">
          <img src="{{ asset('images/logo-icon.png')}}" alt="logo icon">
        </div>
				{{ csrf_field() }}

			  {{-- <input type="" name="_token" value="{{ csrf_token() }}"> --}}
     <!--Start Back To Top Button-->
      <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>

      <p class="pt-2">
      Expand your mind with Changa - your personal psychedelic guide.
Journey deeper into yourself through immersive music, visuals, and meditations. Track your insights. Integrate at your own pace with journaling prompts and education from experts.
Connect with a supportive community of fellow explorers in our safe chat space.
Curated content keeps your experience fresh, with new artists and perspectives in the psychedelic space.
Let Changa guide you through preparation, exploration and integration. Making each psychedelic experience expansive, enlightening and transformational.
</p>
<div class="pt-5">
  <p class="font-weight-bold mt-3 text-right">Contact us: </p>
  <p class="text-right">changa.institute.app@gmail.com</p>
</div>

    <!--End Back To Top Button-->
</div>
  </div>
  </div>
  </div>

	<!--start color switcher-->
   <div class="right-sidebar">
    <div class="switcŽer-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">

      <p class="mb-0">Gaussion Texture</p>
      <hr>

      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>

      <p class="mb-0">Gradient Background</p>
      <hr>

      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
		<li id="theme13"></li>
        <li id="theme14"></li>
        <li id="theme15"></li>
      </ul>

     </div>
   </div>
  <!--end color switcher-->

	</div><!--wrapper-->

{{-- @include('panels/script') --}}

@endsection