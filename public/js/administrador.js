


function crearGrafico(data) {
    const canvas = document.getElementById('myChart');
    if (canvas) {
    Chart.getChart(canvas)?.destroy();
}
    const ctx = document.getElementById('myChart');

// Paso 1: Obtener todas las fechas y descripciones únicas
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

// Paso 2: Crear los conjuntos de datos para cada descripción
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

// Paso 3: Crear la configuración del gráfico
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
    $("#resultado").text(response);
    console.log(data);
    crearGrafico(data);
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
            $("#resultado").text(response);
            console.log(data);
            crearGrafico(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Problema: " + jqXHR.responseText);
        }
    });
});