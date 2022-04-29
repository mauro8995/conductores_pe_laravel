@include('partials.top-index')
@section('title', 'Inicio')
<main>
    <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
        <div class="container">
            <a class="navbar-brand text-primary" href="index.html"><img class="img-responsive" src="{{asset('imagenes/logo.png')}}" alt=""></a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mr-lg-5">
                    <li class="nav-item"><a class="nav-link" href="https://winescompartir.com/test/">Pagina principal </a></li>
                    <li class="nav-item"><a class="nav-link" href="cambiarvehiculo">Cambiar vehiculo</a></li>
                    <li class="nav-item"><a class="nav-link" href="actualizardocumentos">Actualizar documentos</a></li>
                </ul>
                <a class="btn-warning btn rounded-pill px-4 ml-lg-4 text-black" href="acceder">Embajador validador<i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </nav>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary">
        <div class="page-header-content mb-n5">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6">
                        <h1 class="page-header-title">Únete a la primera red social monetizada de transporte</h1>
                        <p class="page-header-text mb-5">Empieza a conducir y a generar ingresos por compartir WIN RIDESHARE</p>
                        <!-- <div class="mb-5 mb-lg-0">
                            <a class="mr-3" href="javascript:void(0);"><img src="assets/img/app-store-badge.svg" style="height: 3rem;"/></a><a href="javascript:void(0);"><img src="assets/img/google-play-badge.svg" style="height: 3rem;"/></a>
                            <div class="page-header-text mt-2 text-xs font-italic">* Requiere Android OS 5.0+ or Apple iOS 5.0+</div>
                        </div> -->
                    </div>
                    <div class="col-lg-6">
                      <div class="card mb-4" id="form-inicio">
                          <div class="card-body p-0">
                              <div class="row no-gutters">
                                  <div class="col-lg-12 align-self-stretch d-lg-flex">
                                    <img class="card-img" src="imagenes/Requisitos.png" alt="Card image">
                                  </div>
                              </div>
                          </div>
                          <div class="car-footer bg-light" style="padding-bottom: 20px !important;">
                            <center><button type="button" id="empezarregister" class="btn btn-primary btn-marketing rounded-pill mt-4">
                                validarme como conductor
                            </button></center>
                          </div>
                      </div>
                      <div class="card rounded-lg text-dark" id="form-registerdriver">
                          <div class="card-header py-4 text-primary">
                            <h2 id="title"></h2>
                          </div>
                          <div class="card-body">
                            <form class="card-text" id="form-newuseregister">
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <div style="display: flex;">
                                      <input type="text" class="form-control form-control-user input-number-letter-m" id="user" name="user" placeholder="Usuario">
                                      <div class="input-group-append">
                                            <button class="btn btn-light btn-user" type="button" data-toggle="tooltip" data-placement="bottom" title="Tu usuario con el que ya te registraste en la aplicación de pasajeros.">
                                              <i class="fa fa-question"></i>
                                            </button>
                                      </div>
                                    </div>
                                    <small id="uservalidate" class="form-text"></small>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <button type="button" id="btn-userregister" class="btn btn-primary btn-user btn-block">
                                      Siguiente paso
                                    </button>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group text-center">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <a class="text-primary" id="rememberuser">¿Olvidaste tu usuario?</a>
                                  </div>
                                </div>
                                <div id="validaruseregs">
                                <br>
                                <div class="form-group text-center">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <h5 class="form-text">¿No tiene usuario? <a href="https://winrideshareapp.page.link/KbdTHoJSMs8nk5n57" >Registrate</a></h5>
                                  </div>
                                </div>
                              </div>
                              </form>
                              <form class="card-text" id="form-rememberusers">
                                <p class="form-text text-black">Introduce tu teléfono o correo electrónico con la que te registraste, para encontrar tu usuario</p>
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <input type="email" class="form-control form-control-user" id="rememberemail" name="rememberemail" placeholder="Correo electronico / telefono">
                                    <small id="rememberuservalidate" class="form-text"></small>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <button type="button" id="btn-rememberuser" class="btn btn-primary btn-user btn-block">
                                      Buscar usuario
                                    </button>
                                  </div>
                                </div>
                                <center>ó</center>

                                <div class="form-group text-center">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <h5 class="form-text"><a href="https://winrideshareapp.page.link/KbdTHoJSMs8nk5n57" >Crear una cuenta nueva</a></h5>
                                  </div>
                                </div>
                                <br>
                                <hr>
                                <div class="form-group text-center">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <h5 class="form-text"><a type="button" onclick="validarmeprinci()">Volver a validarme</a></h5>
                                  </div>
                                </div>
                              </form>
                              <form class="card-text" id="form-datos" >
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <select class="form-control form-control-user" id="type_docs" name="type_docs">
                                      <option selected="selected" value="">Tipo de documento</option>
                                      <option value="1">DNI</option>
                                      <option value="2">CARNET DE EXTRANJERIA</option>
                                      <option value="3">CARNET DE SOLICITANTE</option>
                                      <option value="4">PASAPORTE</option>
                                      <option value="5">PTP</option>
                                    </select>
                                    <small id="typedocsvalidate" class="form-text"></small>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-number" id="num_doc" name="num_doc" placeholder="Numero de documento">
                                    <small id="numdocvalidate" class="form-text"></small>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-letter-space" id="first_name" name="first_name" placeholder="Nombres">
                                    <small id="firstnamevalidate" class="form-text"></small>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-letter-space" id="last_name" name="last_name" placeholder="Apellidos">
                                    <small id="lastnamevalidate" class="form-text"></small>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-number-letter" id="licencia" name="licencia" placeholder="Licencia">
                                    <small id="licenciavalidate" class="form-text"></small>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-number-letter" id="placa" name="placa" placeholder="Placa">
                                    <small id="placavalidate" class="form-text text-gray-900">Solo números y letras.</small>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <select class="form-control form-control-user" id="city" name="provincia" onchange="selectcity(this);">
                                    <option selected="selected" value="">Ciudad donde conduces</option>
                                    <option value="2825">Lima</option>
                                    <option value="2815">Arequipa</option>
                                    <option value="2822">Huancayo</option>
                                    <option value="2824">Chiclayo</option>
                                    <option value="2823">Trujillo</option>
                                    <option value="2820">Huanuco</option>
                                    <option value="2818">Cusco</option>
                                    <option value="2833">Tacna</option>
                                    <option value="2813">Chimbote</option>
                                    <option value="2821">Ica</option>
                                    <option value="2831">Puno</option>
                                    <option value="2828" data-city="32145">Ilo</option>
                                    <option value="2828" data-city="32146">Moquegua</option>
                                  </select>
                                  <small id="cityvalidate" class="form-text"></small>
                                </div>
                                <div class="form-group">
                                  <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Acepto <b id="termnicondi">términos y condiciones</b></label>
                                  </div>
                                  <small id="termcondvalidate" class="form-text"></small>
                                </div>
                                <button type="button" id="btn-datos" class="btn btn-primary btn-user btn-block">
                                  Siguiente paso
                                </button>
                              </form>
                              <form class="card-text" id="form-validate-datos">
                                <p class="form-text text-black">Para asegurarnos de que el correo sea correcto, te enviaremos al siguiente correo un código de verificación de cuatro dígitos.</p>
                                <div class="form-group">
                                  <input type="email" class="form-control form-control-user" id="email" placeholder="Correo electronico">
                                </div>
                                <div class="form-group">
                                  <small id="clock1" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                  <small id="emailvalidate" class="form-text"></small>
                                </div>
                                <div class="form-group row" id="emailvaluser" style="margin-bottom: 1rem;">
                                  <div class="col-md-3 col-sm-3 col-3" style="padding-right: 0.1rem; padding-left: 0.2rem;">
                                    <input type="text" class="form-control form-control-user input-number validateEmailv" id="valemail1" maxlength="1">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-3" style="padding-right: 0.1rem; padding-left: 0.1rem;">
                                    <input type="text" class="form-control form-control-user input-number validateEmailv" id="valemail2" maxlength="1">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-3" style="padding-right: 0.1rem; padding-left: 0.1rem;">
                                    <input type="text" class="form-control form-control-user input-number validateEmailv" id="valemail3" maxlength="1">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-3" style="padding-left: 0.1rem; padding-right: 0.2rem;">
                                    <input type="text" class="form-control form-control-user input-number validateEmailv" id="valemail4" maxlength="1">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6" id="sendverification">
                                    <a href="https://help.wintecnologies.com/actualizaci%C3%B3n-correo-telefono">Este no es mi correo</a>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6" id="valenviar">
                                    <button class="btn btn-primary btn-user btn-block sendcodemail" onclick="validateEmail()" type="button">
                                      Enviar codigo
                                    </button>
                                  </div>
                                </div>
                              </form>
                              <form class="card-text" id="form-validate-datos2">
                                <p class="form-text text-black">Para asegurarnos de que el número sea correcto, te enviaremos un SMS al siguiente numero con un código de verificación de cuatro dígitos.</p>
                                <div class="form-group row" style="margin-bottom: 1px;">
                                  <div class="col-md-2 col-sm-2 col-2" style="padding-right: 0px;">
                                    <img style="width: 28px; float: right;" src="{{asset('imagenes/bandera-pe.png')}}" />
                                  </div>
                                  <div class="col-md-10 col-sm-10 col-10">
                                    <input type="tel" class="form-control form-control-user input-number" id="phone" placeholder="Numero de telefono">
                                  </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12" style="margin-bottom: 1rem;">
                                  <small id="clock" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group row" id="phonevaluser" style="margin-bottom: 1rem;">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <small id="phonevalidate" class="form-text">Ingresa el codigo que se enviara por SMS</small>
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-4" style="padding-right: 0.5rem; padding-left: 0.5rem;">
                                    <input type="text" class="form-control form-control-user input-number sendcodphone" maxlength="1" id="valphone1">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-4" style="padding-right: 0.5rem; padding-left: 0.5rem;">
                                    <input type="text" class="form-control form-control-user input-number sendcodphone" maxlength="1" id="valphone2">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-4" style="padding-right: 0.5rem; padding-left: 0.5rem;">
                                    <input type="text" class="form-control form-control-user input-number sendcodphone" maxlength="1" id="valphone3">
                                  </div>
                                  <div class="col-md-3 col-sm-3 col-4" style="padding-right: 0.5rem; padding-left: 0.5rem;">
                                    <input type="text" class="form-control form-control-user input-number sendcodphone" maxlength="1" id="valphone4">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6" id="codphonever">
                                    <a href="https://help.wintecnologies.com/actualizaci%C3%B3n-correo-telefono">Este no es mi telefono</a>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6" id="valenviartelefono">
                                    <button class="btn btn-primary btn-user btn-block sendvalphone" onclick="validatePhone(1)" type="button">
                                      Enviar codigo
                                    </button>
                                  </div>
                                </div>

                              </form>
                              <form class="card-text" id="form-documentos-driver">
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <button type="button" id="btn-subir-dni" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-dni" style="text-align: left; width: 100%;">DNI/CEDULA/PASAPORTE</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </button>
                                </div>
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <button type="button" id="btn-subir-licencia" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-licencia" style="text-align: left; width: 100%;">LICENCIA DE CONDUCIR</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </button>
                                </div>
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <a href="#" id="btn-subir-tarjvehi" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-tarjvehi" style="text-align: left; width: 100%;">TARJETA VEHICULAR</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </a>
                                </div>
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <button type="button" id="btn-subir-soat" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-soat" style="text-align: left; width: 100%;">SOAT/CAT</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </button>
                                </div>
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <button type="button" id="btn-subir-atu" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 14px;">
                                    <span class="text valid-atu" style="text-align: left; width: 100%;">TARJETA DE CIRCULACION</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </button>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px;">
                                  <button type="button" id="btn-subir-revision" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-revision" style="text-align: left; width: 100%;">REVISION TECNICA</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </button>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12" style="margin-bottom: 1rem;">
                                  <small class="form-text text-gray-600">Subir revision tecnica en caso de que su vehiculo lo requiera</small>
                                </div>
                                <button type="button" id="btn-documentos-driver" class="btn btn-primary btn-user btn-block">
                                  Siguiente paso
                                </button>
                              </form>
                              <form class="card-text" id="form-dni">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6" style="padding-right: 1rem; padding-left: 1rem;">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px" src="{{asset('imagenes/dni_frontal_img.png')}}" id="dni_frontal_img" alt="">
                                    <p class="text-center mb-2">FRONTAL</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="dni_frontal" name="dni_frontal" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-dni_frontal"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6" style="padding-right: 1rem; padding-left: 1rem;">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px" src="{{asset('imagenes/dni_back_img.png')}}" id="dni_back_img"  alt="">
                                    <p class="text-center mb-2">POSTERIOR</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="dni_back" name="dni_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-dni_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia de ambos lados de su documento de identidad y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-dni" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-soat">
                                <div class="form-group row">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <center><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/soat_back_img.png')}}" id="soat_back_img" alt=""></center>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="soat_back" name="soat_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-soat_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia del soat y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-soat" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-atu">
                                <div class="form-group row">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <center><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/atu_back_img.png')}}" id="atu_back_img" alt=""></center>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="atu_back" name="atu_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-atu_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia de circulación del vehículo y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-atu" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-tarjvehi">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px"  src="{{asset('imagenes/tarjveh_frontal_img.png')}}" id="tarjveh_frontal_img" alt="">
                                    <p class="text-center mb-2">FRONTAL</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="tarjveh_frontal" name="tarjveh_frontal" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-tarjveh_frontal"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px"  src="{{asset('imagenes/tarjveh_back_img.png')}}" id="tarjveh_back_img" alt="">
                                    <p class="text-center mb-2">POSTERIOR</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="tarjveh_back" name="tarjveh_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-tarjveh_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia de ambos lados de la tarjeta vehicular y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-tarjvehi" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-licencia">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px" src="{{asset('imagenes/lic_frontal_img.png')}}" id="lic_frontal_img" alt="">
                                    <p class="text-center mb-2">FRONTAL</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="lic_frontal" name="lic_frontal" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-lic_frontal"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 500px; height: 140px" src="{{asset('imagenes/lic_back_img.png')}}" id="lic_back_img" alt="">
                                    <p class="text-center mb-2">POSTERIOR</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="lic_back" name="lic_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-lic_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia de ambos lados de su licencia de conducir y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-licencia" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-revision">
                                <div class="form-group row">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <center><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/revision_img.png')}}" id="revision_img" alt=""></center>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="revision" name="revision" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-revision"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia de la revisión técnica del auto y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-revision" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-documentos-vehicle">
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <a href="#" id="btn-subir-externas" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-externas" style="text-align: left; width: 100%;">FOTOS EXTERNAS</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </a>
                                </div>
                                <div class="form-group" style="margin-bottom: 2px;">
                                  <a href="#" id="btn-subir-laterales" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-laterales" style="text-align: left; width: 100%;">FOTOS LATERALES</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </a>
                                </div>
                                <div class="form-group">
                                  <a href="#" id="btn-subir-internas" class="btn btn-light btn-icon-split btn-lg btn-block" style="font-size: 16px;">
                                    <span class="text valid-internas" style="text-align: left; width: 100%;">FOTOS INTERNAS</span>
                                    <span class="icon text-gray-600">
                                      <i class="fas fa-arrow-right"></i>
                                    </span>
                                  </a>
                                </div>
                                <button type="button" id="btn-documentos-vehicle" class="btn btn-primary btn-user btn-block">
                                  Siguiente paso
                                </button>
                              </form>
                              <form class="card-text" id="form-externas">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/car_frontal_img.png')}}" id="car_frontal_img" alt="">
                                    <p class="text-center mb-2">FRONTAL</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_frontal" name="car_frontal" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_frontal"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/car_back_img.png')}}" id="car_back_img" alt="">
                                    <p class="text-center mb-2">POSTERIOR</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_back" name="car_back" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_back"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia del auto que muestre la parte delantera y posterior, asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-externas" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-laterales">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/car_left_img.png')}}" id="car_left_img" alt="">
                                    <p class="text-center mb-2">IZQUIERDA</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_left" name="car_left" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_left"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/car_right_img.png')}}" id="car_right_img" alt="">
                                    <p class="text-center mb-2">DERECHA</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_right" name="car_right" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_right"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografía del auto que muestre el lado derecho e izquierdo y asegurese de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-laterales" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-internas">
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px" src="{{asset('imagenes/car_passenger_img.png')}}" id="car_passenger_img" alt="">
                                    <p class="text-center mb-2">LADO PASAJERO</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_passenger" name="car_passenger" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_passenger"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 400px; height: 200px"src="{{asset('imagenes/car_driver_img.png')}}" id="car_driver_img" alt="">
                                    <p class="text-center mb-2">LADO COPILOTO</p>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="car_driver" name="car_driver" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-car_driver"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Tome o suba la fotografia del auto que muestre la parte del pasajero y conductor, asegurandose de lo siguiente:</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen completa</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Cortada</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-internas" class="btn btn-primary btn-user btn-block">
                                  Continuar
                                </button>
                              </form>
                              <form class="card-text" id="form-perfil">
                                <div class="form-group row">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <center><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 240px; height: 200px" src="{{asset('imagenes/perfil_img.png')}}" id="perfil_img" alt=""></center>
                                    <div class="input-group">
                                      <label class="input-group-btn text-center" style="width: 100%;">
                                        <span class="btn btn-primary btn-file radioD">
                                        Subir <i class="fas fa-camera"></i><input type='file' class="form-control" id="perfil" name="perfil" accept="image/x-png,image/gif,image/jpeg">
                                      </span><span style="margin: 5px;" class="help-block-perfil"></span>
                                      </label>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <p>Ultimo paso, sube o tomate la foto de perfil para la aplicación.</p>
                                  <p>¡Sonrie!</p>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Imagen nitída</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> Borrosa</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Sin filtros o efectos</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> recortada</p>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-check text-success"></i> Fondo claro</p>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <p><i class="fas fa-times text-danger"></i> gorro o lentes de sol</p>
                                  </div>
                                </div>
                                <button type="button" id="btn-perfil" class="btn btn-primary btn-user btn-block">
                                  Finalizar
                                </button>
                              </form>
                              <form class="card-text" id="form-register">
                                <div class="form-group">
                                  <p>Tu registro esta siendo evaluado por nuestro equipo de soporte. Te informaremos sobre el estado de tu registro en 24 horas a través de tu correo y SMS</p>
                                </div>
                                <div class="form-group">
                                  <center><img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 8rem;" src="{{asset('imagenes/auto-veri.png')}}" alt=""></center>
                                </div>
                              </form>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-border-waves text-light">
            <svg class="wave" style="pointer-events: none" fill="currentColor" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1920 75">
                <defs>
                    <style>
                        .a {
                            fill: none;
                        }
                        .b {
                            clip-path: url(#a);
                        }
                        .d {
                            opacity: 0.5;
                            isolation: isolate;
                        }
                    </style>
                    <clippath id="a"><rect class="a" width="1920" height="75"></rect></clippath>
                </defs>
                <title>wave</title>
                <g class="b"><path class="c" d="M1963,327H-105V65A2647.49,2647.49,0,0,1,431,19c217.7,3.5,239.6,30.8,470,36,297.3,6.7,367.5-36.2,642-28a2511.41,2511.41,0,0,1,420,48"></path></g>
                <g class="b"><path class="d" d="M-127,404H1963V44c-140.1-28-343.3-46.7-566,22-75.5,23.3-118.5,45.9-162,64-48.6,20.2-404.7,128-784,0C355.2,97.7,341.6,78.3,235,50,86.6,10.6-41.8,6.9-127,10"></path></g>
                <g class="b"><path class="d" d="M1979,462-155,446V106C251.8,20.2,576.6,15.9,805,30c167.4,10.3,322.3,32.9,680,56,207,13.4,378,20.3,494,24"></path></g>
                <g class="b"><path class="d" d="M1998,484H-243V100c445.8,26.8,794.2-4.1,1035-39,141-20.4,231.1-40.1,378-45,349.6-11.6,636.7,73.8,828,150"></path></g>
            </svg>
        </div>
    </header>
    <section class="bg-light py-10">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="smartphone"></i></div>
                    <h3>Gana de tus propias carreras</h3>
                    <p class="mb-0">Mediante la aplicación podrás ampliar tu cartera de cliente.</p>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="dollar-sign"></i></div>
                    <h3>Comisión más baja</h3>
                    <p class="mb-0">Paga solamente el 15% de cada servicio.</p>
                </div>
                <div class="col-lg-4">
                    <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="users"></i></div>
                    <h3>Refiere y gana</h3>
                    <p class="mb-0">Gana el 5% por todos los viajes que completen tus referidos.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white py-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-6 order-1 order-lg-0 z-1" data-aos="fade-right">
                    <div class="content-skewed content-skewed-right">
                      <div class="device-wrapper mx-auto mb-n15">
                          <div class="device" data-device="iPhoneX" data-orientation="portrait" data-color="black">
                              <div class="screen">
                                <!-- <img class="img-fluid z-1" src="https://source.unsplash.com/eluzJSfkNCk/518x1122" /> -->
                                <video controls style="height: 100%; z-index: 9999;" class="img-fluid z-1"><source src="imagenes/prueba2.mp4" type="video/mp4"></video>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="col-lg-6 order-0 order-lg-1 mb-5 mb-lg-0" data-aos="fade-left">
                    <div class="mb-5">
                        <h2>¿Cómo me registro en Win?</h2>
			<p>El registro inicia desde la aplicación de pasajero.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h6><div class="icon-stack flex-shrink-0 bg-primary text-white">1</div> Selecciona REGISTRATE</h6>
                            <p class="mb-2 small">Inicia ingresando el usuario de quien te invitó (?).</p>
                        </div>
                        <div class="col-md-12 mb-4">
                            <h6><div class="icon-stack flex-shrink-0 bg-primary text-white">2</div> Ingresa tus datos personales</h6>
                            <p class="mb-2 small mb-0">Completa tu registro con los datos que te solicitan.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h6><div class="icon-stack flex-shrink-0 bg-primary text-white">3</div> Crea tu usuario</h6>
                            <p class="mb-2 small mb-0">Debes crear tu nombre de usuario para que puedas referir.</p>
                        </div>
                        <div class="col-md-12 mb-4">
                            <h6><div class="icon-stack flex-shrink-0 bg-primary text-white">4</div> Ingresa tu correo y crea una contraseña </h6>
                            <p class="small mb-0">Finalmente, valida tu número de celular.</p>
                        </div>
			<div class="col-md-12 mb-4">
                            <h6><div class="icon-stack flex-shrink-0 bg-primary text-white">5</div> Ahora inicia la validación de tus documento</h6>
                            <p class="small mb-0">Vuelve al inicio de la página y selecciona en "VALIDARME COMO CONDUCTOR".</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1>¿Como gana un conductor WIN?</h1>
            </div>
            <div class="row no-gutters align-items-center z-1">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="card pricing pricing-left">
                        <div class="card-body p-5">
                          <div class="text-center">
                              <div class="badge badge-primary-soft badge-pill badge-marketing badge-sm text-primary">Por tu red de pasajeros</div>
                              <div class="pricing-price">20%</div>
                          </div>
                          <ul class="fa-ul pricing-list">
                              <li class="pricing-list-item">
                                  <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Gana un 10% de tu primer grupo de invitados más un 10% de tu segundo grupo de invitados.</span>
                              </li>
                              <li class="pricing-list-item">
                                  <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Gana de tus invitados pasajeros, directos e indirectos (invitados de tus invitados).</span>
                              </li>
                              <li class="pricing-list-item">
                                  <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">El limite de tus ganancias solo lo pones tú.</span>
                              </li>
                              <li class="pricing-list-item">
                                  <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Tus ganancias seran mensuales y serán un tercer ingreso adicional.</span>
                              </li>
                          </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="card pricing py-4 z-1">
                        <div class="card-body p-5">
                            <div class="text-center">
                                <div class="badge badge-primary-soft badge-pill badge-marketing badge-sm text-primary">Por usar la app</div>
                                <div class="pricing-price">15%</div>
                            </div>
                            <ul class="fa-ul pricing-list">
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Paga la comisión más baja del mercado</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Ahorre un aproxima de 40% respecto a la comisión de otras aplicaciones</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Genera ganancias adicionales</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Te brindamos una oficina virtual (Para hacer seguimiento de tu red social)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="card pricing pricing-right">
                        <div class="card-body p-5">
                            <div class="text-center">
                                <div class="badge badge-primary-soft badge-pill badge-marketing badge-sm text-primary">Por tu red de conductores</div>
                                <div class="pricing-price">10%</div>
                            </div>
                            <ul class="fa-ul pricing-list">
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Gana un 5% de tu primer grupo de invitados más un 5% de tu segundo grupo de invitados.</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Gana de tus invitados directos e indirectos (invitados de tus invitados).</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">El limite de tus ganancias solo lo pones tú.</span>
                                </li>
                                <li class="pricing-list-item">
                                    <span class="fa-li"><i class="far fa-check-circle text-teal"></i></span><span class="text-dark">Tus ganancias seran mensuales y serán un ingreso adicional para ti.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
        </div>
    </section>
    <section class="bg-dark py-2">
        <div class="container">
            <div class="row my-10">
                <div class="col-lg-6 mb-5">
                    <div class="d-flex h-100">
                        <div class="icon-stack flex-shrink-0 bg-primary text-white"><i class="fas fa-question"></i></div>
                        <div class="ml-4">
                            <h5 class="text-white">¿Cómo me registro en la oficina virtual?</h5>
                            <p class="text-white-50">El primer paso para unirte a Win es registrarte en la red social (oficina virtual). El registro lo realizas desde la aplicación de pasajero WIN RIDESHARE PASAJERO, allí podrá registrarte con el código de invitación de tu patrocinador o la persona que te refirió.</p>
                            <a class="text-white-50" href="https://help.wintecnologies.com/registro-pasajero">ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="d-flex h-100">
                        <div class="icon-stack flex-shrink-0 bg-primary text-white"><i class="fas fa-question"></i></div>
                        <div class="ml-4">
                            <h5 class="text-white">¿Cómo puedo invitar o referir?</h5>
                            <p class="text-white-50">Desde tu aplicación puede invitar a sus amigos pasajeros y conductores, solo compartiendo tu código de usuario desde REFIERE Y GANA.</p>
                            <a class="text-white-50" href="https://help.wintecnologies.com/todos-los-conductores-vamos-a-referir-desde-la-aplicaci%C3%B3n ">ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="d-flex h-100">
                        <div class="icon-stack flex-shrink-0 bg-primary text-white"><i class="fas fa-question"></i></div>
                        <div class="ml-4">
                            <h5 class="text-white">¿Cómo ingreso a la aplicación de conductor?</h5>
                            <p class="text-white-50">Después de haber pasado por los filtros de evaluación y ser aprobado, podrás iniciar sesión en la aplicación de conductor. Primero, deberás descargar la aplicación WIN RIDESHARE CONDUCTOR e iniciar sesión con su correo/número de teléfono y tu contraseña.</p>
                            <a class="text-white-50" href="https://help.wintecnologies.com/ingresar-app-conductor">ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex h-100">
                        <div class="icon-stack flex-shrink-0 bg-primary text-white"><i class="fas fa-question"></i></div>
                        <div class="ml-4">
                            <h5 class="text-white">¿Dónde puedo revisar mis ganancias?</h5>
                            <p class="text-white-50">Tus ganancias de tus servicios lo puedes visualizar desde tu aplicación de conductor y tus ganancias por tus invitados también lo podrás visualizar desde tu aplicación (próximamente). Hemos desarrollado un simulador de ganancias, en donde puedes calcular un aproximado de lo que ganarías por tus invitados o referidos.</p>
                            <a class="text-white-50" href="https://help.wintecnologies.com/calculadora-de-ganancias-residuales-de-win">ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="badge badge-transparent-light badge-pill badge-marketing mb-4">Centro de ayuda</div>
                    <h2 class="text-white">¿Necesitas ayuda?</h2>
                    <p class="lead text-white-50 mb-5">Si tienes dudas alguna duda con respecto a la información o necesitas mayor información, revisa nuestro centro de ayuda.</p>
                    <a class="btn btn-primary btn-marketing rounded-pill lift lift-sm" href="#!">Ir a centro de ayuda</a>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white py-10">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h4>DESCARGA LA APLICACION</h4>
                    <p class="lead mb-5 mb-lg-0">Disponible en IOS y android</p>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <a class="mr-3" href="https://apps.apple.com/pe/app/win-rideshare/id1458838759"><img src="assets/img/app-store-badge.svg" style="height: 3rem;"/></a><a href="https://play.google.com/store/apps/details?id=com.winrideshare.passenger&hl=es"><img src="assets/img/google-play-badge.svg" style="height: 3rem;"/></a>
                </div>
            </div>
        </div>
    </section>
</main>
<div id="la">CONSENTIMIENTO LEGAL

Al aceptar el formulario de registro y hacer clic en la casilla
de acepto términos y condiciones, doy pleno consentimiento para
que WIN TECNOLOGIES INC S. A. recopile, procese mi información
y datos personales sensibles para evaluar mi elegibilidad para
poder emplear la Plataforma virtual de WIN TECNOLOGIES INC S. A.
como conductor y para todos los fines descritos en la Declaración
de Privacidad de Win amparado en la ley de Protección de datos
personales Ley N° 29733

PROTOCOLO SANITARIO

Está aceptando tener conocimiento y ser responsable del cumplimiento
de los Protocolosde Bioseguridad establecidos por el gobierno durante
la pandemia Covid 19.
Asumiendo cualquier responsabilidad administrativa y penal en caso de
incumplimiento de los mismos.

Copyright (c) 2020 WIN RIDESHARE
</div>
<div id="load_inv" class="load_inv" style="display:none; color: black; z-index: 10; position: fixed; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
  <div class="modal-content-load" style="margin: center;  padding: 20px;  width: 100%;">
    <div class="d-flex justify-content-center">
      <div class="spinner-border" style="width: 4rem; height: 4rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
</div>
@include('partials.footer-index')
