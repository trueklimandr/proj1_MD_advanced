function getXmlHttp(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function showTimeDialog(docId) {

    var request, dialog, errDiv, response, block, tableDiv;

    request = getXmlHttp();
    request.open('Get', '/main/get-slots?doctorId=' + docId);
    request.send();

    dialog = document.getElementById('dialog'+docId);
    errDiv = document.getElementById('error'+docId);

    dialog.showModal();

    document.getElementById("cancel"+docId).onclick = function() {
        dialog.close();
    };

    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {


                response = JSON.parse(request.responseText);

                if (response.length === 0) {
                    errDiv.innerHTML = '<h3 style="color:red">Sorry, there is no slots.</h3>';
                    return;
                }

                block = '<table class="table">\n<thead>\n<tr><th>Date</th><th>Time</th><th></th></tr>\n</thead>\n<tbody>\n';

                response.forEach(function(item, i, response) {
                    block +=
                        '<tr><td>' + item['date'] + '</td><td>' + item['start'] + ' - ' + item['end'] + '</td>' +
                        '<td><a' +
                            ' class="btn btn-xs btn-success"' +
                            ' href="' + window.location.protocol + '//' + window.location.hostname +
                                '/main/choose-record?slotId=' + item['id'] + '"' +
                        '>record</a></td></tr>\n';
                });

                block += '</tbody>\n</table>';

                tableDiv = document.getElementById('table'+docId);
                tableDiv.innerHTML = block;

            } else {
                errDiv.innerHTML = 'Произошла ошибка при запросе: ' +  request.status + ' ' + request.statusText;
            }
        }
    };
}
