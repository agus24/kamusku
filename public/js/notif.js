function loadNotif() {
    let user_id = User.id;
    $.ajax({
        async :true,
        url: Url + "/api/getNotif",
        data: {
            user_id : user_id
        },
        type: "GET"
    }).done((result) => {
        let html = '';
        if(result.length > 0) {
            $('#navbarDropdown').addClass('has-notif');
        }
        $.each(result, (key,value) => {
            let style = '';
            if(value.read_at == null) {
                style = "background-color: #ffafaf;";
            }
            html += `<li style="padding: 10px;`+style+`">
                <a href="`+Url+`/`+value.data.tipe+`/`+value.data.id+`?notif_id=`+value.id+`">
                    User `+value.data.user.name+` Telah `+value.data.text+`
                    <span style="float:right">`+value.diff+`</span>
                </a>
            </li>`;
        });
        $('#notifDropdown').empty()
        $('#notifDropdown').append(html)
    }).fail(error => {
        console.log(error);
    });
}

if(User.id != undefined) {
    loadNotif(User.id);
    // setInterval(loadNotif, 5000);
}
