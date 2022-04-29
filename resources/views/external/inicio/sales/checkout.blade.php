
    @extends('layout-simple')
    @section('title', 'Pago por tarjeta')
    @section('content')

    <section class="content">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Pagar con tarjeta
            <small class="pull-right"></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
          <!-- pagar con tarjeta -->
          <div class="form-group">
            <div class="row">
              <div class="col-xs-9" id="pago" data-amount="{{ $monto }}" data-desc="{{ $ticket->getProduct[0]->cant }} {{ $ticket->getProduct[0]->name_product}}" data-mon="{{ $ticket->getMoney[0]->{'description'} }}" data-dni="{{ $ticket->getCustomer->dni }}" data-id="{{ $id }}"><label for="Datos">Pago con tarjeta</label>
                <div class="input-group valpago">
                  <div class="input-group-addon">
                    <i class="fa  fa-credit-card"></i>
                  </div>
                    <button type="button" name="btn_culqi" id="btn_culqi">pagar</button>
                </div>
              </div>
            </div>
          </div>



          <div id="load_inv" class="load_inv" style="display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
            <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
              <center><div class="overlay" style="color: #fff !important;"><i class="fa fa-refresh fa-spin" style="font-size:50px"></i></div></center>
            </div>
          </div>


    </section>
    @endsection
    @section('script')
    <script src="{{ asset('js/External/sales/checkout.js')}}"></script>
    @endsection
