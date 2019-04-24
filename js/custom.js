//this function appends the json data to the table 'gable'
function append_json(data) {

    var table = document.getElementById('gable');

    data.forEach(function(obj) {
        //console.log(obj);
        var tr = document.createElement('tr');
         tr.innerHTML = '<td>' + obj.currencyTo + '</td>' +
                        '<td>' + obj.rate + '</td>';
        table.appendChild(tr);
    });
}

//this function clears the table
function clearTable()
{
    var table = document.getElementById("gable");

    for(var i = table.rows.length - 1; i > 0; i--)
    {
        table.deleteRow(i);
    }
}

//this function retrieves the currency from the route
function updateCurrency($currency)
{
    console.log($currency);
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'api/exchange/get/'+ $currency);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(this.responseText);
            clearTable();
            append_json(data);
        }
        else {
            alert('Request failed. Returned status of ' + xhr.status);
        }
    };
    xhr.send();
}

window.onload = function() {
    updateCurrency('EUR');
};