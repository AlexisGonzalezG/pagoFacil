<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Pago facil</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <br />
        <div class="container text-center shadow-lg p-3 mb-5 bg-body rounded">
            <div class="row">
                <div class="col">
                    <span class="input-group-text">Nombre *</span>
                    <input type="text" class="form-control" id="nombre" style="text-align: center;" />
                </div>
                <div class="col">
                    <span class="input-group-text">Apellidos *</span>
                    <input type="text" class="form-control" id="apellidos" style="text-align: center;" />
                </div>
                <div class="col">
                    <span class="input-group-text">Numero de Tarjeta *</span>
                    <input type="text" class="form-control" id="numeroTarjeta" placeholder="xxxx-xxxx-xxxx-xxxx" style="text-align: center;" />
                </div>
                <div class="col">
                    <span class="input-group-text">Monto *</span>
                    <input type="number" class="form-control" id="monto" style="text-align: center;" />
                </div>
                <div class="col">
                    <span class="input-group-text">Mes *</span>
                    <select class="form-select" id="mesExpiracion" multiple aria-label="multiple select example">
                        <option disabled selected>Seleccione...</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col">
                    <span class="input-group-text">Año *</span>
                    <select class="form-select" id="anyoExpiracion" multiple aria-label="multiple select example">
                        <option disabled selected>Seleccione...</option>
                        <option value="22">2022</option>
                        <option value="23">2023</option>
                        <option value="24">2024</option>
                        <option value="25">2025</option>
                        <option value="26">2026</option>
                    </select>
                </div>
                <div class="col">
                    <span class="input-group-text">CVV *</span>
                    <input type="text" id="cvt" class="form-control" style="text-align: center;" />
                </div>
                <div class="col">
                    <button type="button" id="btn_transaccion" class="btn btn-warning" onclick="transaccion()">Enviar</button>
                </div>
            </div>
        </div>
        <div class="container text-center shadow-lg p-3 mb-5 bg-body rounded">
            <img id="img_cargando" src="{{URL::asset('img/cargando.gif')}}" width="250" style="display: none;" />
            <div class="row">
                <div class="col">
                    <select class="form-select" onchange="get_transaccions(this.value)">
                        <option disabled selected>Seleccione tipo de tarjeta de credito...</option>
                        <option value="0">Todas</option>
                        <option value="1">Visa</option>
                        <option value="2">Master Card</option>
                        <option value="3">American Express</option>
                    </select>
                    <br />

                    <table class="table table-success table-striped">
                        <thead>
                            <th>Autorizado</th>
                            <th>Transaccion</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>NumeroTarjeta</th>
                            <th>TipoTC</th>
                            <th>Monto</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <!-- Modal Detalle-->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal_detail">
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
    </div>
</html>
  <script>

get_transaccions();

function transaccion() {
    nombre = $("#nombre").val();
    apellidos = $("#apellidos").val();
    numeroTarjeta = $("#numeroTarjeta").val();
    mesExpiracion = $("#mesExpiracion option:selected").val();
    anyoExpiracion = $("#anyoExpiracion option:selected").val();
    cvt = $("#cvt").val();
    monto = $("#monto").val();

    if (nombre && apellidos && numeroTarjeta && mesExpiracion && anyoExpiracion && cvt && monto) {
        $("#btn_transaccion").attr("disabled", true);
        $("#img_cargando").show();

        $.ajax({
            type: "POST",
            url: "transaccion",
            data: {
                _token: "{{ csrf_token() }}",
                numeroTarjeta: numeroTarjeta,
                cvt: cvt,
                mesExpiracion: mesExpiracion,
                anyoExpiracion: anyoExpiracion,
                nombre: nombre,
                apellidos: apellidos,
                idSucursal: "560d73f2a001c6d40dd805ab9ccafdeabf37cec3",
                idUsuario: "a2bce1f48cf7d11fae7d662d8bf7513355adf96f",
                monto: monto,
            },
            success: function (response) {
                if (response.ok == 100) {
                    Swal.fire("Enviado", "Datos enviados", "success");
                    $("#numeroTarjeta").val("");
                    $("#cvt").val("");
                    $("#nombre").val("");
                    $("#apellidos").val("");
                    $("#monto").val("");
                    get_transaccions();
                    $("#img_cargando").hide();
                } else {
                    swalWithBootstrapButtons.fire("ERROR", "Ocurrio un error", "error");
                }
                $("#btn_transaccion").attr("disabled", false);
            },
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Campos vacios",
            text: "Todos los campos son obligatorios",
        });
    }
}

function get_transaccions(valor) {
    html = "";
    autorizado = "";

    $.ajax({
        type: "POST",
        url: "get_transaccions",
        data: {
            _token: "{{ csrf_token() }}",
            TipoTC: valor,
        },
        success: function (response) {
            if (response.ok == 100) {
                const obj = JSON.parse(response.data);
                obj.forEach(function (objj, index) {
                    if (objj.autorizado == 1) {
                        autorizado = "<p class='text-success'>" + objj.autorizado + "</p>";
                    } else {
                        autorizado = "<p class='text-danger'>" + objj.autorizado + "</p>";
                    }

                    html +=
                        "<tr>" +
                        "<td>" +
                        autorizado +
                        "</td>" +
                        "<td>" +
                        objj.transaccion +
                        "</td>" +
                        "<td>" +
                        objj.nombre +
                        "</td>" +
                        "<td>" +
                        objj.apellidos +
                        "</td>" +
                        "<td> XXXX-XXXX-XXXX-" +
                        objj.numeroTarjeta.substr(12, 16) +
                        "</td>" +
                        "<td>" +
                        objj.TipoTC +
                        "</td>" +
                        "<td>" +
                        formatterPeso.format(objj.monto) +
                        "</td>" +
                        "<td><button type='button'  onclick ='buscar_(" +
                        objj.id +
                        ")' class='btn btn-light' data-bs-toggle='modal' data-bs-target='#modalDetail'>Detail</button></td>" +
                        "<td><button type='button' onclick ='delete_(" +
                        objj.id +
                        ") 'class='btn btn-danger'>Delete</button></td>" +
                        "</tr>";
                });
            } else {
                html = "<tr>" + "<td colspan = 9>SIN DATOS ENCONTRADOS</td>" + "</tr>";
            }

            $("#tbody").html(html);
        },
    });
}

function delete_(id) {
    $.ajax({
        type: "POST",
        url: "delete_transaccion",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
        },
        success: function (response) {
            if (response.ok == 100) {
                Swal.fire("Eliminada", "Transaccion eliminada", "success");
                get_transaccions();
            } else {
                swalWithBootstrapButtons.fire("ERROR", "Ocurrio un error", "error");
            }
        },
    });
}

function buscar_(id) {

    html = "";
    $("#modal_detail").html(html);


    $.ajax({
        type: "GET",
        url: "transaccion_id/"+id,
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (response) {
            if (response.ok == 100) {

                const obj = JSON.parse(response.data);
                console.log("detail",obj);

                html = "<table class='table'>"+
                         "<tr>"+
                         "<th>Method</th>"+
                         "<th>Numero Tarjeta</th>"+
                         "<th>CVT</th>"+
                         "<th>Mes Expiracion</th>"+
                         "<th>Anio Expiracion</th>"+
                         "<th>Monto</th>"+
                         "</tr>"+
                         "<tr>"+
                         "<td>"+obj[0].method+"</td>"+
                         "<td>"+obj[0].numeroTarjeta+"</td>"+
                         "<td>"+obj[0].cvt+"</td>"+
                         "<td>"+obj[0].mesExpiracion+"</td>"+
                         "<td>"+obj[0].anyoExpiracion+"</td>"+
                         "<td>"+formatterPeso.format(obj[0].monto)+"</td>"+
                         "</tr>"+
                        "</table>";


                $("#modal_detail").html(html);

            
            } else {
                swalWithBootstrapButtons.fire("ERROR", "Ocurrio un error", "error");
            }
        },
    });

}

const formatterPeso = new Intl.NumberFormat("es-mx", {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 0,
});


  </script>
</html>