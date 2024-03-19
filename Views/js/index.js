$(document).ready(function() {
    loadData();
});

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
                $('#paymentsInfo').css('display', 'block');
            }
        },
        error: function(xhr, status, error) {
            alert("Error en la solicitud: " + error);
        }
    });
}

function fillTableWithContent(data) {

    const tbodyRef = document.getElementById('paymentsInfo').getElementsByTagName('tbody')[0];
    iterateData(data, tbodyRef);
}

function displayAdditionalInformation(data) {

    const tfooterRef = document.getElementById('paymentsInfo').getElementsByTagName('tfoot')[0];
    iterateData(data, tfooterRef);
}

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

