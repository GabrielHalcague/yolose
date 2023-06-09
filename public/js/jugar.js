var finButton = $('#fin');
var trampaButton = $('#trampa');
var segundos = document.getElementById('tiempoRestante').innerText;
var cronometro;
$(document).ready(function () {
    var cantTrampasActuales = trampaButton.text(); //Trampas restantes: 3
    var val = cantTrampasActuales.split(' ');
    console.log("trampas actuales: "+ val[3]);
    if (val[3] <= 0) {
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

    reporte();

});


const reporte = () => {
    $('.reporte').click(function (){
        var preguntaId= $(this).val()
        $.ajax({
            url: '/partida/reportarPregunta',
            method: 'POST',
            data: {preguntaId: preguntaId}
        }).done(function (){
            $('.reporte').prop('disabled',true)
        });
    });
}


function cuentaRegresiva() {
    document.getElementById('tiempoRestante').innerHTML = segundos;
    if (parseInt(segundos) === 0) {
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
            respuestaValida.css('backgroundColor', 'green');
            setTimeout(function (){
                $(location).attr('href',"/partida&tipoPartida="+data['tipoPartida']);
            },5000);
        }
    } else {
        respuestaValida.css('backgroundColor', 'green');
        terminarPartida();
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
        console.log(response);
        var data = JSON.parse(response);
        console.log(data);
        // Access and use the data
        if (data.success) {
            // Operación exitosa
            var datos = data.data;
            console.log(datos);
            $('#result').text(datos['resultado']);
            var tipoPartida=undefined;
            switch(datos['tipo']){
                case '1':
                    tipoPartida = "Solitario";
                    break;
                case '2':
                    tipoPartida = "VS BOT";
                    $('#resultBot').text(datos['respuestasBot']);
                    break;
                case '3':
                    tipoPartida = "P v P";
                    $('#resultadoPVP').text(datos['resultado']);
                    break;
                default:
                    tipoPartida = "";
                    break;
            }
            $('#tPartida').text(tipoPartida);
            $('#ventana').modal('show');

        }
    }).fail(function (xhr, status, error) {
        // Handle error, if any
        console.log(error);
    });
}