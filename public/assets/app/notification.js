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
                    $.each(res.data, function (k, v) {


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


                $('#count-surat_keluar').text(res.surat_keluar.count || 0);
                if (parseInt(res.surat_keluar.count || 0) > 0) {
                    $.each(res.surat_keluar.data, function (k, v) {

                        const _task = (v.pemaraf1 == parseInt(userid) || v.pemaraf2 == parseInt(userid)) ? 'Paraf' : (v.pettd == parseInt(userid)) ? 'Tanda Tangan' : false;
                        console.log(_task);

                        if (_task != false) {
                            const _item = `
                            <div class="dropdown-divider"></div>
                            <a href="/surat-keluar/${v.id}/detail" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                    <h3 class="dropdown-item-title text-bold">${v.created_by_name}</h3>
                                    <p class="text-sm">Penugasan ${_task} Surat Keluar: ${v.perihal_surat}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ${v.created_at}</p>
                                    </div>
                                </div>
                            </a>`;

                            $("#container-surat_keluar").append(_item);
                        } else {
                            const _item = `
                            <div class="dropdown-divider"></div>
                            <a href="/surat-keluar/${v.id}/detail" class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                    <h3 class="dropdown-item-title text-bold">${v.rejected_by}</h3>
                                    <p class="text-sm"><span class="badge badge-danger mt-3">Reject</span> Surat Keluar: ${v.perihal_surat}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ${v.reject_date}</p>
                                    </div>
                                </div>
                            </a>`;

                            $("#container-surat_keluar").append(_item);
                        }

                    });

                    const _see_all = `<a href="/surat-keluar" class="dropdown-item dropdown-footer">Lihat semua</a>`;
                    $('#container-surat_keluar').append(_see_all);

                }

            }
            // console.log(res)
        }
    })
}