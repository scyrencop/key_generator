const URL_INDEX = 'http://localhost:8000/api/index';
const URL_CREATE = 'http://localhost:8000/api/store';
const URL_DELETE = 'http://localhost:8000/api/delete';

function generateUUID() {
    var d = new Date().getTime();

    if (window.performance && typeof window.performance.now === "function") {
        d += performance.now();
    }

    var uuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'.replace(/[x]/g, function (c) {
        var r = (d + Math.random() * 16) % 16 | 0;
        d = Math.floor(d / 16);
        return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });

    return uuid;
}

// Generate new key and insert into input value
$('#keygen').on('click', function () {
    $('#key').val(generateUUID());
});


fetch(URL_INDEX)
    .then(response => response.json())
    .then(data => {
        console.log(data);

        for (let i = 0; i < data.data.length; i++) {
            let tr = $('<tr></tr>');
            let td_id = $('<td>'+data.data[i].id+'</td>');
            let td_name = $('<td>'+data.data[i].name+'</td>');
            let td_key = $('<td>'+data.data[i].key+'</td>');
            let td_created_at = $('<td>'+data.data[i].created_at+'</td>');

            let form_delete = $(' <button class="btn btn-danger" onclick="deleteKey('+data.data[i].id+')"> Delete</button>');

            let td_actions = $('<td></td>');
            td_actions.append(form_delete);

            tr.append([td_id, td_name, td_key, td_created_at, td_actions])

            $('#my_table').append(tr);
        }

    })
    .catch(error => {
        console.error(error)
    })


function deleteKey(id){
    var sure = confirm('Do you want to delete the Key ?')
    if (sure){
        fetch(URL_DELETE+id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data.success){
                    alert('Key Deleted Successfully !')
                    window.location.reload(); 
                }
            })
            .catch(error => console.error(error))
    }
}

function createKey(){
    if($('#key').val() == ''){
        alert('Key field is required');
    }else{

        fetch(URL_CREATE, {
            method: "POST",
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: $('#name').val(),
                key: $('#key').val(),
            }) })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    alert('Key Created Successfully !')
                    window.location.reload(); 
                }
            })
            .catch(error => console.error(error))
    }

}
