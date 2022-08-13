$(() => {
    getNotification()

})

function getNotification() {
    $.ajax({
        url: '/api/notification',
        method: 'get',
        data: {
            user_id: userid
        },
        success: (res) => {
            if (res.transaction) {
                $("#count_notification").text(res.count)

                if (res.count > 0) {
                    $.each(res.data, function(k, v) {


                        if (v.jenis == 'surat-masuk') {
                            const item = '<a href="/surat-masuk/detail/' + v.id +
                                '" class="dropdown-item">' +
                                '<p style="display:flex;flex-wrap: wrap;">Penugasan Surat <i class="ml-2"> ' +
                                v.nomor_surat + '</i></p>' +
                                '<div><span class="badge text-bg-primary" style="background-color:#198754;color:white">Surat ' +
                                'Masuk</span></div>' +
                                '<div style="font-size: 12px;">' + v.created_at + '</div>' +
                                '</a>';

                            $("#container-notification").append(item);
                        } else {
                            const item = '<a href="#" class="dropdown-item">' +
                                '<p style="display:flex;flex-wrap: wrap;"> Tandatangan Surat <i class="ml-2">12/02/2000</i></p>' +
                                '<div><span class="badge text-bg-primary" style="background-color:#fd7e14;color:white">Surat' +
                                'Keluar</span></div>' +
                                '<div style="font-size: 12px;">2022-02-12</div>' +
                                '</a>';
                        }

                        const divider = '<div class = "dropdown-divider" > < /div>';
                        $("#container-notification").append(divider);

                    })
                } else {
                    $("#container-notification").html(
                        '<a href="#" class="dropdown-item dropdown-footer">Tidak Ada Notifikasi</a>')
                }

            }
            console.log(res)
        }
    })
}