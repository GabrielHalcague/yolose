$(document).ready(function () {
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('exampleModal')
    myModal.addEventListener('click', () => {
        myInput.show();
    })


    $('#validarNick').click(function () {
        $('#confirmarNick').attr("disabled", "disabled");
        $('#nuevoNickOculto').val($('#nuevoNick').val());

        var valorInput = $('#nuevoNickOculto').val();

        $.ajax({
            url: '/perfil/editar',
            method: 'POST',
            data: {nickName: valorInput},
            beforeSend: function () {
                $("#nickNameEstado").html("Procesando, espere por favor...");
            },
            success: function (response) {
                const data = JSON.parse(response);
                var estado = data.nicknameEstado;
                console.log(estado);
                if (estado === null) {
                    $("#nickNameEstado").html('disponible');
                    $('#confirmarNick').removeAttr("disabled");
                } else {
                    $("#nickNameEstado").html('no Disponible');
                }
            }
        })
    });
    $('#confirmarNick').click(function () {
        var valorInput = $('#nuevoNickOculto').val();
        var idUsuario = $('#idUsuario').val();

        $.ajax({
            url: '/perfil/confirmar',
            method: 'POST',
            data: {nickName: valorInput, idUsuario: idUsuario},
            beforeSend: function () {
                $("#nickNameEstado").html("Procesando, espere por favor...");
            },
            success: function (response) {
                const data = JSON.parse(response);
                var estado = data.nicknameEstado;
                console.log(estado);
                if (estado === null) {
                    $("#nickNameEstado").html('Reintentar');
                } else {
                    $("#nickNameEstado").html('Se cambio el usuario');
                    location.reload()
                }
            }
        })
    });
});

