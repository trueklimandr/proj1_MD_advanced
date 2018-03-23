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

    var request = getXmlHttp();
    request.open('Get', '/main/get-slots?doctorId=' + docId);
    request.send();

    var dialog = document.getElementById('dialog'+docId);
    var errDiv = document.getElementById('error'+docId);

    dialog.showModal();

    document.getElementById("cancel"+docId).onclick = function() {
        dialog.close();
    };

    request.onreadystatechange = function() {
        if(request.readyState === 4) {
            if(request.status === 200) {
                var response = JSON.parse(request.responseText);

                if (response.length === 0) {
                    errDiv.innerHTML = '<h3 style="color:red">Sorry, there is no slots.</h3>';
                    return;
                }
                var slotDate = document.getElementById('slotDate'+docId);
                var slotStart = document.getElementById('slotStart'+docId);
                var slotEnd = document.getElementById('slotEnd'+docId);
                var slotChoose = document.getElementById('slotChoose'+docId);

                response.forEach(function(item, i, response) {
                    var divDate = document.createElement('div');
                    divDate.innerText = item['date'];
                    var divStart = document.createElement('div');
                    divDate.innerText = item['start'];
                    var divEnd = document.createElement('div');
                    divDate.innerText = item['end'];
                    var divChoose = document.createElement('button');
                    divChoose.innerText = item['Record'];
                    divChoose.id = 'choose'+item['doctorId'];

                    slotDate.appendChild(divDate);
                    slotStart.appendChild(divStart);
                    slotEnd.appendChild(divEnd);
                    slotChoose.appendChild(divChoose);
                });

            } else {
                errDiv.innerHTML = 'Произошла ошибка при запросе: ' +  request.status + ' ' + request.statusText;
            }
        }
    };
}
