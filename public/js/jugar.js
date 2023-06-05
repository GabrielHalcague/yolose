$(document).ready(function () {
    $('#fin').hide();
    $('#continuar').hide();
    var cantTrampasActuales = $('#trampa').val();
    if(cantTrampasActuales === 0){
        $('#trampa').prop('disabled', true);
    }
    // Attach click event handler to the button
    $('.opcion').click(function () {
        // Execute AJAX function
        const id = $(this).val();
        console.log(id);
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
        }).fail(function (xhr, status, error) {
            // Handle error, if any
            console.log(error);
        });
    });
});

function validarRespuesta(data) {
    console.log("En funcion validar");
    console.log(data);
    const respuestaActual = $("." + data["respActual"]);
    const respuestaValida = $("." + data["respValida"]);
    if (data["fueraTiempo"] === false) {
        if (data['correcto'] === false) {
            respuestaValida.prop('backgroundColor', 'green');
            respuestaActual.prop('backgroundColor', 'red');
            terminarPartida();
            $('#fin').show();
        }
        if (data['correcto'] === true) {
            respuestaActual.prop('backgroundColor', 'green');
            $('#continuar').show();
        }
    } else {
        respuestaValida.prop('backgroundColor', 'green');
        $('#fin').show();
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

            $('#puntos').val(datos['score']);
            $('#result').val(datos['resultado']);

            $('#ventana').modal('show');

        }
    }).fail(function (xhr, status, error) {
        // Handle error, if any
        console.log(error);
    });
}


