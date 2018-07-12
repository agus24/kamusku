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
    console.log('masuk')
    let id = bahasa.val();
    axios.get(baseURI + '/api/kata/', {
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

function makeAutoComplete(textBox, data) {
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
    console.log(baseURI + '/api/getTranslate/?dari='+dari+"&ke="+ke+"&kata="+kata);
    console.log("send post");
    $.ajax({
        "async": true,
        "url" : baseURI + '/api/getTranslate/?dari='+dari+"&ke="+ke+"&kata="+kata,
        "type" : "get"
    }).done((response) => {
        let data = response
        let output = $('#detail-ke');
        console.log(response);
        $('#topResult').empty();
        if(data.length != 0) {
            let topResult = data[0];
            console.log(topResult);
            $('#topResult').append(topResult.dari_kata.bahasa_id != ke ? topResult.tujuan_kata.kata : topResult.dari_kata.kata);
            $('#topResult').append("<br><i>Contoh Kalimat :</i> <br>");
            $('#topResult').append(topResult.dari_kata.bahasa_id != ke ? topResult.tujuan_kata.contoh_kalimat : topResult.dari_kata.contoh_kalimat);
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
        } else {
            $('#topResult').append("<span style='color:red'>Tidak ada terjemahan</span>");
        }
    }).fail((error) => {
        alert(error)
    })
}
