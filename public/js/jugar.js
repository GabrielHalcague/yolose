var finButton = $('#fin');
var continuarButton = $('#continuar');
var trampaButton = $('#trampa');
var segundos = 10;
var cronometro;
$(document).ready(function () {
    finButton.hide();
    continuarButton.hide();
    var cantTrampasActuales = trampaButton.val();
    if (cantTrampasActuales === 0) {
        trampaButton.prop('disabled', true);
    }
    cuentaRegresiva();

    // Attach click event handler to the button
    $('.opcion').click(function () {
        // Execute AJAX function
        const id = $(this).val();
        clearTimeout(cronometro);
        $.ajax({
            url: '/partida/verificar',
            method: 'POST',
            data: {id: id}
        }).done(function (response) {
            var data = JSON.parse(response);
            // Access and use the data
            if (data.success) {
                // Operación exitosa
                var message = data.message;
                var datos = data.data;

                // Hacer algo con los datos en caso de éxito
                validarRespuesta(datos);


            }
        });
    });

    $('.reporte').click(function (){
        var preguntaId= $(this).val()
        $.ajax({
            url: '/partida/reportarPregunta',
            method: 'POST',
            data: {preguntaId: preguntaId}
        }).done(function (){
            $('.reporte').prop('disabled',true)
        })

    })

});


function cuentaRegresiva() {
    document.getElementById('tiempoRestante').innerHTML = segundos;
    if (segundos === 0) {
        clearTimeout(cronometro);
        $.ajax({
            url: '/partida/verificar',
            method: 'POST',
            data: {id: 'FUERA_TIEMPO'}
        }).done(function (response) {
            var data = JSON.parse(response);
            // Access and use the data

            if (data.success) {
                var datos = data.data;

                // Hacer algo con los datos en caso de éxito
                console.log("SE FUE DE TIEMPO");
                console.log(data);
                $("#" + data["respValida"]).css('backgroundColor', 'green');
                terminarPartida();
                finButton.show();
                disableButtons();
            }
        });
    } else {
        segundos = segundos - 1;
        cronometro = setTimeout(cuentaRegresiva, 1E3)
    }
}


function validarRespuesta(data) {
    console.log("En funcion validar");
    console.log(data);
    const respuestaActual = $("#" + data["respActual"]);
    const respuestaValida = $("#" + data["respValida"]);
    if (data["fueraTiempo"] === false) {
        if (data['correcto'] === false) {
            respuestaValida.css('backgroundColor', 'green');
            respuestaActual.css('backgroundColor', 'red');
            terminarPartida();
            finButton.show();
        }
        if (data['correcto'] === true) {
            respuestaActual.css('backgroundColor', 'green');
            setTimeout(function (){
                $(location).attr('href',"http://localhost:80/partida&tipoPartida="+data['tipoPartida']);
            },5000);
            //continuarButton.show();
        }
    } else {
        respuestaValida.css('backgroundColor', 'green');
        finButton.show();
    }
    disableButtons();
}

function disableButtons() {
    $('.opcion').each(function () {
        $(this).prop('disabled', true);
    });
}

const terminarPartida = () => {
    $.ajax({
        url: '/partida/partidaTerminada',
        method: 'POST',
        data: {id: ''},
        processData: false,
    }).done(function (response) {

        var data = JSON.parse(response);

        // Access and use the data
        if (data.success) {
            // Operación exitosa
            var datos = data.data;
            console.log(datos);
            $('#result').data('resultado', datos['resultado']);
            $('#tPartida').data('tipoPartida', datos['tipo']);
            $('#ventana').modal('show');

        }
    }).fail(function (xhr, status, error) {
        // Handle error, if any
        console.log(error);
    });
}