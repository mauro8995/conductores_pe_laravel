  @include('partials.top')
  @include('partials.header')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 header-p">
      <div  class="row" >
        <div id="scene">
          <div data-depth="0.1">
            <img  style="padding: 5%;"
            src="https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Flogo_win.png?alt=media&token=d5040807-ca7d-4f0e-ad43-1e003d1e11f4" alt="">
          </div>
        </div>
      </div>
        <div  class="row">
          <div class="col-sm-12 col-md-5 col-lg-7 col-xl-7">
          </div>
          <div class="col-sm-12 col-md-7 col-lg-5 col-xl-5">
            <div id="scene2" >
              <div data-depth="0.3"  style="height: 290px;background-image:
                url('https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fconductores.PNG?alt=media&token=2bffa419-f050-4b80-ab91-624d97235e7b');
                  background-repeat: no-repeat;">
                </div>
              </div>
          </div>
        </div>
    </div>
<main role="main" id="main" class="row section-main" style="background-color : #08426a;color:white;">
  @yield('content')
</main>
@section('script')
    <script src="{{ asset('js/External/inicio.js')}}"></script>
@endsection
@include('partials.footer')
