@include('partials.top-index')
@section('title', 'Inicio')

                      <div class="card mb-4" id="form-inicio" style="height: 100vh;">
                           
			   <div class="card-body p-0" style="background-position: center; background-size: cover; background-image: radial-gradient(circle at center,rgba(230,236,240,0.5) 0%,rgba(230,236,240,0.9) 100%),url(https://winescompartir.com/assets/img/win_stock5.jpg)!important;">
                           <h5 class="card-header ">Para empezar con el registro tiene que tener a la mano los siguientes documentos:</h5>
 
			    </div>
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



<header class="">
        <div class="">
            <div class="">
                <div class="">
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
                                    <a class="text-primary" href="https://help.wintecnologies.com/conocer-usuario">¿Olvidaste tu usuario?</a>
                                  </div>
                                </div>
                                <br>
                                <div class="form-group text-center">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <h5 class="form-text">¿No tiene usuario? <a href="https://winrideshareapp.page.link/KbdTHoJSMs8nk5n57" >Registrate</a></h5>
                                  </div>
                                </div>
                              </form>
                              <form class="card-text" id="form-rememberusers">
                                <p class="form-text text-black">Introduce tu telefono o correo electrónico con el que te registraste y te enviaremos un correo con tu usuario.</p>
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <input type="email" class="form-control form-control-user" id="rememberemail" name="rememberemail" placeholder="Correo electronico">
                                    <small id="rememberuservalidate" class="form-text"></small>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-md-12 col-sm-12 col-12">
                                    <button type="button" id="btn-rememberuser" class="btn btn-primary btn-user btn-block">
                                      Buscar
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
                                    <input type="text" class="form-control form-control-user input-letter" id="first_name" name="first_name" placeholder="Nombres">
                                    <small id="firstnamevalidate" class="form-text"></small>
                                  </div>
                                  <div class="col-md-6 col-sm-6 col-6">
                                    <input type="text" class="form-control form-control-user input-letter" id="last_name" name="last_name" placeholder="Apellidos">
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
                                  <select class="form-control form-control-user" id="city" name="provincia">
                                    <option selected="selected" value="">Ciudad donde conduces</option>
                                    <option value="2825">Lima</option>
                                    <option value="2815">Arequipa</option>
                                    <option value="2822">Huancayo</option>
                                    <option value="2824">Chiclayo</option>
                                    <option value="2823">Trujillo</option>
                                    <option value="2820">Huanuco</option>
                                    <option value="2818">Cusco</option>
                                    <option value="2833">Tacna</option>
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
    </header>


        </div>
      </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script-sb-ui-pro.js') }}"></script>
        <script src="{{ asset('js/Driver/created.js?v=22') }}"></script>
        <script src="{{ asset('plugins/JIC/dist/JIC.min.js')}} " type="text/javascript"></script>
        <!-- Iserta js personalizado de cada vista -->
        @yield('js')
        <script>
      feather.replace()
    </script>
        <script>
            AOS.init({
                disable: 'mobile',
                duration: 600,
                once: true
            });
        </script>
    </body>
</html>
