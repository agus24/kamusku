function openNewTranslate()
{
    $('#buttonCreate').fadeOut(() => {
        $('#formCreate').fadeIn();
    });
}

$('#buttonBatal').click((ev, el) => {
    $('#formCreate').fadeOut(() => {
        $('#buttonCreate').fadeIn();
    });
});

function searchKata() {
    let text_kata = $('#text_kata').val();
    let bahasa_id = $('#dari_bahasa').val();
    $.ajax({
        async: false,
        url: Url+"/api/getKata",
        data: {
            text_kata : text_kata,
            bahasa_id : bahasa_id
        },
        type: "POST"
    }).done(result => {
        console.log(result);
        let html = ``;
        let i = 1;
        $.each(result, (key, value) => {
            html += `<tr>
                <td>`+i+`</td>
                <td>`+value.kata+`</td>
                <td><button class="btn btn-primary" onclick="pilihKata(`+value.id+`)">Pilih</button></td>
            </tr>`;
            i++
        })
        $('#tabelKata').empty();
        $('#tabelKata').append(html);
        $('#modalKata').modal('show');
    }).fail(error => {
        alert(error);
    })
}

function pilihKata(kata_id) {
    $('#kata_group').removeClass('has-error');
    $('#kata_group').removeClass('has-success');
    $('#kata_group').addClass('has-success');
    $('#hdn_kata').val(kata_id);
    $('#modalKata').modal('hide');
}
