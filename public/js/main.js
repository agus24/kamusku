$(document).ready(function() {
    $('#cmb-dari').change((e) => {
        loadKata($('#cmb-dari'));
    });
    $('#btnTranslate').click((e) => {
        let dari = $('#cmb-dari').val(),
            ke = $('#cmb-ke').val()
            kata = $('#text-dari').val();
        getTranslateData(dari, ke, kata);
    });
    makeAutoComplete('dari', src);
});

function loadKata(bahasa) {
    let id = bahasa.val();
    axios.get('/api/kata/', {
        params: {
          bahasa_id : id
        }
    }).then(function (response) {
        let data = response.data;
        let textBox = bahasa.attr('id').split('-')[1];
        makeAutoComplete(textBox, data);
    }).catch(function (error) {
        alert('gagal mengambil data kata');
    });
}

function makeAutoComplete(textBox, data)
{
    $('#text-'+textBox).autocomplete({
        source : data,
        minLength : 3,
        change: function( event, ui ){
            let item = ui.item;
            $('#hidden-'+textBox).val(item.id);
            console.log($('#hidden-'+textBox).val());
        }
    });
}

function getTranslateData(dari, ke, kata) {
    axios.post('/api/getTranslate/', {
        params: {
            dari : dari,
            ke : ke,
            kata : kata
        }
    }).then((response) => {
        let data = response.data
        let output = $('#detail-ke');
        if(data.length != 0) {
            $('#topResult').empty();
            let topResult = data[0];
            $('#topResult').append(topResult.dari_kata.bahasa_id != ke ? topResult.tujuan_kata.kata : topResult.dari_kata.kata);
            $('#detail-ke').empty();
            let html = `<span style="font-size:16px; font-weight:bold">Terjemahan Lain</span><ul style="list-style: none;">`;
            if(data.length > 1) {
                let i = 0;
                $.each(data, (key,value) => {
                    if(i != 0) {
                        html += `<li>`+value.tujuan_kata.kata+`<li>`;
                    }
                    i++;
                });
                html += `</ul>`;
                $('#detail-ke').append(html);
            }
        }
    }).catch((error) => {
        alert(error);
    });
}
