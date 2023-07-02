$(document).ready(function () {
    /*const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('exampleModal')
    myModal.addEventListener('click', () => {
        myInput.show();
    });*/

    var contenido = $('#nUsuario').html();
    contenido = contenido.replace('<strong>Usuario:</strong>', '').trim();
    var map = L.map('map');
    $.ajax({
        url: '/perfil/obtenerCoordenadas',
        method: 'POST',
        data: {username: contenido}
    }).done(function (response) {
        var data = JSON.parse(response);
        const coord = L.latLng(data['lat'],data['lng']);
        console.log(coord);
        map.setView(coord, 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 25,}).addTo(map);
        L.circle(coord, {radius: 500}).addTo(map);
    });


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
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
// Mostrar por defecto el Tab1
document.getElementById('Tab1').style.display = 'block';
document.getElementsByClassName('tablinks')[0].classList.add('active');
