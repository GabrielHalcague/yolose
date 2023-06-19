

function crearGrafico(data) {
    const canvas = document.getElementById('myChart');
    if (canvas) {
    Chart.getChart(canvas)?.destroy();
}
    const ctx = document.getElementById('myChart');

// Obtener todas las fechas y descripciones unicas
    var labels = [];
    var descriptions = [];

    data.forEach(function(obj) {
    if (!labels.includes(obj.campoFiltro)) {
    labels.push(obj.campoFiltro);
}

    if (!descriptions.includes(obj.descripcion)) {
    descriptions.push(obj.descripcion);
}
});

// Crear los conjuntos de datos para cada descripcion
    var datasets = [];

    descriptions.forEach(function(desc) {
    var dataArr = [];

    labels.forEach(function(fecha) {
    var cantidad = 0;

    data.forEach(function(obj) {
    if (obj.campoFiltro === fecha && obj.descripcion === desc) {
    cantidad = parseInt(obj.cantidad);
}
});

    dataArr.push(cantidad);
});
    datasets.push({
    label: desc,
    data: dataArr
});
});

//  Crear la configuracion del grafico
    var chartConfig = {
    type: 'bar',
    data: {
    labels: labels,
    datasets: datasets
},
    options: {
    scales: {
    y: {
    beginAtZero: true
}
}
}
};
    // Paso 4: Crear el grafico
    new Chart(ctx, chartConfig);
}

$('#consultar').click(function () {
    var selectElement = document.getElementById('tipo');
    var tipoConsulta1 = selectElement.value;
    var fechaInicio1 = $('#fechaInicio').val();
    var fechaFin1 = $('#fechaFin').val();

    var radioButtons = document.getElementsByName('exampleRadios');
    var valorFiltro = '';
    for (var i = 0; i < radioButtons.length; i++) {
    if (radioButtons[i].checked) {
    valorFiltro = radioButtons[i].value;
    break;
}
}
    $.ajax({
    url: '/administrador/consultaPorTipo',
    method: 'POST',
    data: {
    tipoConsulta: tipoConsulta1,
    fechaInicio: fechaInicio1,
    fechaFin: fechaFin1,
    filtro : valorFiltro
},
    beforeSend: function () {
    $("#resultado").html("Procesando, espere por favor...");
},
    success: function (response) {
    var data = JSON.parse(response);
    $("#resultado").text('');
   // console.log(data);
    crearGrafico(data);
    $("#generatePDF").removeAttr('disabled');
},
    error: function(jqXHR, textStatus, errorThrown) {
    alert("Problema: " + jqXHR.responseText);
}
});
});

$('#consultarUsuario').click(function () {
    var selectElement = document.getElementById('tipo');
    var tipoConsulta1 = selectElement.value;
    var fechaInicio1 = $('#fechaInicio').val();
    var fechaFin1 = $('#fechaFin').val();
    var usuarioId = $('#usuarioId').val();

    var radioButtons = document.getElementsByName('exampleRadios');
    var valorFiltro = '';
    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            valorFiltro = radioButtons[i].value;
            break;
        }
    }
    $.ajax({
        url: '/administradorUsuario/consultaPorId',
        method: 'POST',
        data: {
            tipoConsulta: tipoConsulta1,
            fechaInicio: fechaInicio1,
            fechaFin: fechaFin1,
            filtro : valorFiltro,
            usuarioId : usuarioId
        },
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor...");
        },
        success: function (response) {
            var data = JSON.parse(response);
            $("#resultado").text('');
            //console.log(data);
            crearGrafico(data);
            $("#generatePDF").removeAttr('disabled');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Problema: " + jqXHR.responseText);
        }
    });
});

$('#generatePDF').click(function() {
    const canvas = document.getElementById('myChart');
    // Convertir el canvas a una imagen base64
    const imageData = canvas.toDataURL('image/png');
    var consulta =  $('#tipo option:selected').text();

    // Crear un formulario y agregar la imagen base64 como un campo oculto
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/administrador/generarPDF';
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'imageData';
    input.value = imageData;
    form.appendChild(input);
    const titulo = document.createElement('input');
    titulo.type = 'hidden';
    titulo.name = 'consulta';
    titulo.value = consulta;
    form.appendChild(titulo);
    document.body.appendChild(form);
    form.submit();
});