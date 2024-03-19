$(document).ready(function() {
    loadData();
});

/**
 * Envía una solicitud AJAX para cargar datos y actualizar la interfaz.
 * */
function loadData() {

    $.ajax({
        type: "POST",
        url: "index_ajax.php",
        dataType: "json",
        success: function (response) {

            if (response.error) {
                alert(response.error);
            } else {
                fillTableWithContent(response.data);
                displayAdditionalInformation(response.info);
                $('#paymentsInfo').removeClass('d-none');
            }
        },
        error: function(xhr, status, error) {
            alert("Error en la solicitud: " + error);
        }
    });
}

/**
 * Envía a la vista los datos procesados.
 * */
function fillTableWithContent(data) {

    const tbodyRef = document.getElementById('paymentsInfo').getElementsByTagName('tbody')[0];
    iterateData(data, tbodyRef);
}

/**
 * Envía a la vista la información resumida a partir de los datos procesados.
 * */
function displayAdditionalInformation(data) {

    const tfooterRef = document.getElementById('paymentsInfo').getElementsByTagName('tfoot')[0];
    iterateData(data, tfooterRef);
}

/**
 * Genera filas y columnas para la tabla de la vista basándose en el objeto de datos procesados.
 * */
function iterateData(data, element) {

    data.forEach(function(info) {
        var newRow = document.createElement('tr');
        for (var key in info) {
            var newCell = document.createElement('td');
            if (info.hasOwnProperty(key)) {
                if (typeof info[key] === 'object') {
                    var object = info[key];
                    var transformedObject = [];
                    for (let key_transformed in object) {
                        transformedObject[key_transformed] = key_transformed + ': '+ object[key_transformed];
                    }
                    iterateData([transformedObject], newCell)
                } else {
                    newCell.textContent = info[key];
                }
            }
            newRow.appendChild(newCell);
        }
        element.appendChild(newRow);
    });
}

