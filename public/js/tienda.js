$(document).ready(function () {
    $('.comprar').click(function () {
        const id = $(this).val();
        console.log(id);
        $(this).prop('disabled', true);
        $.ajax({
            url: '/tienda/guardarPackSeleccionado',
            method: 'POST',
            data: {id: id}
        }).done(function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                var datos = data.data;

                if (datos['failure'] === false) {
                    setTimeout(function () {
                        $(location).attr('href', "/tienda/mostrarTarjeta");
                    }, 1E3);

                }
            }
        });
    });
});