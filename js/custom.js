function updateCurrency($currency)
{
    console.log($currency);
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'exchange/get/'+ $currency);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(this.responseText);
            append_json(data);
           // console.log(data);
        }
        else {
            alert('Request failed. Returned status of ' + xhr.status);
        }
    };
    xhr.send();
}

//this function appends the json data to the table 'gable'
function append_json(data){
    var table = document.getElementById('gable');
    data.forEach(function(object) {
        var tr = document.createElement('tr');
        // tr.innerHTML = '<td>' + 'test' + '</td>' +
        //     '<td>' + 'test' + '</td>' +
        // table.appendChild(tr);
        console.log('tst');
    });
}