function deleteActivity(id, name){
    if (!confirm('Desea borrar ' + name)) {
        return;
    }
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if(this.readyState== 4 && this.status == 200) {
            var res= JSON.parse(this.responseText);
            if(res.deleted === true){
                var row=document.querySelector('#row'+id);
                row.parentNode.removeChild(row);
            }
        }
    };
    ajax.open("post","delete_activity_json.php",true);
    ajax.setRequestHeader("Content-Type","application/json;charset=UTF-8");
    ajax.send(JSON.stringify({"id":id}));
}
var delayTimer;
function searchForActivities(currentSearch){
    clearTimeout(delayTimer);
    if (currentSearch.length > 2) {
        hide(document.getElementById('no-result'));
        delayTimer = setTimeout(function() {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function() {
                if(this.readyState== 4 && this.status == 200) {
                    var res= JSON.parse(this.responseText);
                    show(document.getElementById('result'));
                    if (res['length']>0) {
                        hide(document.getElementById('not-found'));
                        show(document.getElementById('content-table'));
                        var trHTML = '';
                        for (let i = 0; i< res['length']; i++) {
                            var date = new Date(0);
                            date.setUTCSeconds(res['result'][i]['inicio']);
                            var day =date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            trHTML += '<tr><td><a href="detail.php?activity='
                            +res['result'][i]['id']+ '">'+ res['result'][i]['nombre']
                            +'</a></td><td>'+ res['result'][i]['tipo'] + '</td><td>'+
                            day+'/'+month+'/'+year + '</td><td>'+
                            res['result'][i]['precio'] + '</td><tr>';
                        }
                        document.getElementById('activities-table').innerHTML = trHTML;
                    } else {
                        hide(document.getElementById('content-table'));
                        show(document.getElementById('not-found'));
                    }
                }
            };
            ajax.open("post","search_activity_json.php",true);
            ajax.setRequestHeader("Content-Type","application/json;charset=UTF-8");
            ajax.send(JSON.stringify({"currentSearch": currentSearch}));
        }, 300);   
    }
}

function validateActivityForm() {
    var formContent = document.forms['activityForm'];
    var trigger = true;
    if (formContent['name'].value.length <= 2 || formContent['name'] >= 32) {
        var name = document.getElementById('valid_name');
        name.innerHTML = 'El nombre ha de contener entre 2 y 32 caracteres';
        name.classList.add('no-valid-field');
        trigger = false;
    }
    if ( formContent['capacity'].value <= 0 ) {
        var capacity = document.getElementById('valid_capacity');
        capacity.innerHTML = 'El aforo ha de ser mayor que 0';
        capacity.classList.add('no-valid-field');
        trigger = false;
    }
    if (formContent['price'].value < 0) {
        var price = document.getElementById('valid_price');
        price.innerHTML = 'El precio debe ser mayor o igual a 0';
        price.classList.add('no-valid-field');
        trigger = false;
    }
    if (formContent['description'].value.length < 12 || formContent['description'].value.length > 1024) {
        var description = document.getElementById('valid_description');
        description.innerHTML = 'La descripción debe contener entre 12 y 1024 caracteres';
        description.classList.add('no-valid-field');
        trigger = false;
    }
    
    if (formContent['type'].value.length < 1 || formContent['type'].value.length > 16) {
        var type = document.getElementById('valid_type');
        type.innerHTML = 'El tipo debe contener entre 1 y 16 caracteres';
        description.classList.add('no-valid-field');
        trigger = false;
    }
    
    const today = new Date();
    const date = new Date(document.getElementById('date').value);
    var date1 = date.getDate();
    var date2 = today.getDate();
    if (date1<date2) {
        var DOMElementDate = document.getElementById('valid_date');
        DOMElementDate.innerHTML = 'Introduzca una fecha válida';
        DOMElementDate.classList.add('no-valid-field');
        trigger = false;
    }
    
    const startTime = document.getElementById('from').value;
    const endTime = document.getElementById('to').value;
    var startTimeComponents = startTime.split(':');
    var endTimeComponents = endTime.split(':');
    var startInMillis = (+startTimeComponents[0]*(60000 *60) + startTimeComponents[1]*(60000));
    var endInMillis = (+endTimeComponents[0]*(60000 *60) + endTimeComponents[1]*(60000));
    var finalTime = endInMillis - startInMillis;
    if (finalTime < 0) {
        var time = document.getElementById('valid_time');
        time.innerHTML = 'Introduzca un dominio horario válido';
        time.classList.add('no-valid-field');
        trigger = false;
    }
    
    if (trigger) {
        return true
    }
    return false;
}

function show (element) {
    element.style.display = 'initial';
}


function hide (element) {
    element.style.display = 'none';
}

function toggle(element){
    if (window.getComputedStyle(element).display === 'initial') {
        hide(element);
        return;
    }
    show(element);
}