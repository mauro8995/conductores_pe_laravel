@extends('layout-backend')
@section('title', 'Error' )

@section('css')

@endsection

@section('content')
	<section class="content-header">
		<h1>401 Error</h1>
	</section>


	<section class="content">
       <div class="error-page">
         <h2 class="headline text-yellow"> 404</h2>

         <div class="error-content">
           <h3><i class="fa fa-warning text-yellow"></i> Usuario NO autorizado.</h3>
         </div>
         <!-- /.error-content -->
       </div>
       <!-- /.error-page -->
     </section>

@endsection

@section('js')


@endsection
