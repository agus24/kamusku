function loadNotif(user_id) {
    $.ajax({
        async :true,
        url: Url + "/api/getNotif",
        data: {
            user_id : user_id
        },
        type: "GET"
    }).done((result) => {
        let html = '';
        $.each(result, (key,value) => {
            html += `<li style="padding: 10px">
                <a href="`+Url+`/`+value.data.tipe+`/`+value.data.id+`?notif_id=`+value.id+`">
                    User `+value.data.user.name+` Telah `+value.data.text+`
                    <span style="float:right">`+value.diff+`</span>
                </a>
            </li>`;
        });
        $('#notifDropdown').empty()
        $('#notifDropdown').append(html)
    }).fail(error => {
        alert("error load notifications");
        console.log(error);
    });
}

if(User.id != undefined) {
    loadNotif(User.id);
    setInterval("loadNotif", 5000);
}
