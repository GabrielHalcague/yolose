//si toca un boton va a verificar y le pasa el id del boton que toco
//verificar devulve id del boton y de respuesta correcta en caso de que sea haya equivocado
$(document).ready(function () {
    // Attach click event handler to the button
    $('.btn').click(function () {
        // Execute AJAX function
        var id = $(this).val();


        $.ajax({
            url: 'partida/verificar',
            method: 'POST',
            data: {id: id},
            success: function (response) {
                console.log(response);
                var data = JSON.parse(response);

                // Access and use the data
                if (data.success) {
                    // Operación exitosa
                    var message = data.message;
                    var datos = data.data;

                    // Hacer algo con los datos en caso de éxito
                    validarRespuesta(datos);

                }
            },
            error: function (xhr, status, error) {
                // Handle error, if any
                console.log(error);
            }
        });
    });
});


//valida la respues y pinta de color los botones en base a respuesta
//ademas muestra boton fin si se equivoco y lleva a inicio
//o continuar si responde bien y recarga consulta
function validarRespuesta(data) {

    var respuestaCorrecta;
    var respuestaIncorrecta;
    var botonFin;
    var botonContinuar;

    if (data["respActual"] != undefined && data["respValida"] != undefined) {

        respuestaCorrecta = document.getElementById(data["respValida"]);
        respuestaIncorrecta = document.getElementById(data["respActual"]);
        botonFin = document.getElementById("fin");
        respuestaCorrecta.style.backgroundColor = 'green';
        respuestaIncorrecta.style.backgroundColor = 'red';
        botonFin.style.display = 'block';
        $('#ventana').modal('show');
        disableButtons();
    } else {
        respuestaCorrecta = document.getElementById(data["respValida"]);
        botonContinuar = document.getElementById("continuar");
        respuestaCorrecta.style.backgroundColor = 'green';
        botonContinuar.style.display = 'block';
        disableButtons();
    }

}

function disableButtons() {
    var buttons = document.getElementsByClassName("btn");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].disabled = true;
    }
}