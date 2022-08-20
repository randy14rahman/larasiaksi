$(() => {
    getDetailSuratMasuk()
    getTrackingList()
});

function getDetailSuratMasuk() {
    $.ajax({
        url: `/api/surat-masuk/${id_surat}/detail`,
        success: (res) => {
            $("#button-action").html('')
            if (res.transaction) {
                $("#iframe-preview-pdf").attr('src', `${res.data.link_file}#toolbar=0`)
                $("#nomor_surat>span").text(res.data.nomor_surat)
                $("#perihal_surat>span").text(res.data.perihal_surat)
                $("#tanggal_surat>span").text(res.data.tanggal_surat)
                $("#jenis_surat_masuk>span").text(res.data.jenis_surat_masuk)
                $("#tanggal_upload>span").text(`${res.data.created_by_name} | ${res.data.created_at}`)
                $('#assign_to>span').text(`${res.data.assign_to.name} | ${res.data.assign_to.jabatan}`);

                if (res.disposisi.length > 0) {

                    $('#card-table_disposisi').removeClass('d-none');

                    $.each(res.disposisi, (k, v) => {
                        $('#table-disposisi tbody').append(`<tr>
                            <td>${v.source_disposisi.name}<br/>${v.source_disposisi.nip}<br/>${v.source_disposisi.jabatan}</td>
                            <td>${v.target_disposisi.name}<br/>${v.target_disposisi.nip}<br/>${v.target_disposisi.jabatan}</td>
                            <td>${v.created_at}</td>
                            <td>${v.keterangan}</td>
                        </tr>`);
                    });

                }

                console.log(user_id);
                console.log(res.data);
                console.log(res.data.is_proses);
                // console.log(res.disposisi[res.disposisi.length-1].target_disposisi.id==user_id);

                if (
                    (
                        (res.data.assign_to.id==user_id && res.disposisi.length==0)
                        ||
                        (res.data.is_disposisi==1 && res.disposisi.length>0 && res.disposisi[res.disposisi.length-1].target_disposisi.id==user_id)
                    ) && res.data.is_proses==null
                ){

                    $('#card-action').removeClass('d-none');
                    const btnAction =
                        ' <button type="button" class="btn btn-primary" onclick="processSurat()">Proses Surat</button>' +
                        '<button type="button" class="btn btn-success" onclick="openModalDisposisi()" style="margin-left:16px">Disposisi ' +
                        'Surat</button>';

                    $("#button-action").append(btnAction)
                } else if (
                    res.data.is_proses==1 && 
                    (
                        (res.disposisi.length>0 && res.disposisi[res.disposisi.length-1].target_disposisi.id==user_id) ||
                        (res.pemroses.id!=undefined && res.pemroses.id==user_id)
                    ) &&
                    res.data.is_arsip==null
                ){
                    $('#card-action').removeClass('d-none');
                    const btnAction =
                        ' <button type="button" class="btn btn-primary" onclick="openModalSelesai()">Selesai</button>';

                    $("#button-action").append(btnAction)

                }


            }
        }
    })
}

function processSurat() {

    Swal.fire({
        title: "Are you sure?",
        text: "Apakah anda yakin akan memproses Surat ini ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/surat-masuk/${id_surat}/proses-surat`,
                method: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: (res) => {
                    if (res.transaction) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Surat Masuk Diproses',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                location.reload();
                                // getDetailSuratMasuk()
                                // getTrackingList()

                                // $("#disposisiModal").modal('hide')
                            }
                        });
                    }
                }
            })
        }
    })
    console.log('process surat')

}

function openModalDisposisi() {
    $("#disposisiModal").modal('show')

    getListDisposisiAssign();

}

function openModalSelesai() {
    $("#selesaiModal").modal('show')
}

function getListDisposisiAssign() {
    $.ajax({
        url: '/api/surat-masuk/list-disposisi-assign',
        method: 'get',
        data: {
            role_id: user_role
        },
        success: (res) => {
            if (res.transaction) {
                $("#list_disposisi_assign").html('')
                $.each(res.data, (k, v) => {
                    var list = '<option value="' + v.id + '">' + v.name + '</option>';

                    $("#list_disposisi_assign").append(list)
                })
            }
            console.log(res)
        }
    })
}

function getTrackingList() {
    $.ajax({
        url: `/api/surat-masuk/${id_surat}/tracking`,
        success: (res) => {
            if (res.transaction) {
                $("#container-step").html('');

                $.each(res.data, (k,v)=>{

                    const _active = (v.datetime!=null) ? '-active' : '';

                    $('#container-step').append(`
                        <div class="timeline-step">
                             <div class="timeline-content" >
                                <p class="h6 text-muted mb-4 mb-lg-4"><i>${v.label}</i></p>
                                <div class="inner-circle${_active}"></div>
                                <p class="h6 mt-3 mb-1">${v.actor.name||''}</p>
                                <p class="h6 text-muted mb-0 mb-lg-0"><i>${v.actor.jabatan||''}</i></p>
                                <p class="h7 text-muted mb-0 mb-lg-0">${v.datetime||''}</p>
                             </div>
                        </div>
                    `);
                });
                // var selesai = false;
                // // const last_index = res.data.length - 1
                // // console.log(res.data.length)
                // $.each(res.data, (k, v) => {
                //     selesai = v.status == 'Selesai' ? true : false
                //     var status = v.proses == 1 ? 'Proses' : v.status
                //     // const active = k == last_index ? 'inner-circle-active' : 'inner-circle'
                //     const step = '<div class="timeline-step">' +
                //         '<div class="timeline-content" >' +
                //         '<p class="h6 text-muted mb-4 mb-lg-4"><i>' + status + '</i></p>' +
                //         '<div class="inner-circle-active"></div>' +
                //         '<p class="h6 mt-3 mb-1">' + v.name + '</p>' +
                //         '<p class="h6 text-muted mb-0 mb-lg-0"><i>' + v.role + '</i></p>' +
                //         '<p class="h7 text-muted mb-0 mb-lg-0">' + v.date + '</p>' +
                //         '</div>' +
                //         '</div>';

                //     $("#container-step").append(step)

                // })

                // if (selesai == false) {
                //     const step = '<div class="timeline-step">' +
                //         '<div class="timeline-content" >' +
                //         '<p class="h6 text-muted mb-4 mb-lg-4"><i>Selesai</i></p>' +
                //         '<div class="inner-circle' +
                //         '"></div>' +
                //         '<p class="h6 mt-3 mb-1"></p>' +
                //         '<p class="h6 text-muted mb-0 mb-lg-0"><i></i></p>' +
                //         '<p class="h7 text-muted mb-0 mb-lg-0"></p>' +
                //         '</div>' +
                //         '</div>';

                //     $("#container-step").append(step)
                // }

            }
        }
    })
}

function disposisiSurat() {
    var id_disposisi = $("#list_disposisi_assign").val()
    // $("#close-modal").click()


    $.ajax({
        url: '/api/surat-masuk/disposisi-surat',
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            assign_to: id_disposisi,
            keterangan: $('#disposisi_keterangan').val(),
            id_surat: id_surat,
            user_id: user_id
        },
        success: (res) => {
            if (res.transaction) {
                $("#disposisiModal").modal('hide')

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Surat Masuk berhasil Disposisi',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                        // getDetailSuratMasuk()
                        // getTrackingList()
                    }
                });
            }
        }
    })
}

function arsipkanSurat(){
    var id_disposisi = $("#list_disposisi_assign").val()
    // $("#close-modal").click()


    $.ajax({
        url: `/api/surat-masuk/${id_surat}/arsipkan-surat`,
        method: 'post',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keterangan: $('#selesai_keterangan').val(),
        },
        success: (res) => {
            if (res.transaction) {
                $("#disposisiModal").modal('hide')

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Surat Masuk berhasil Disposisi',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                        // getDetailSuratMasuk()
                        // getTrackingList()
                    }
                });
            }
        }
    })

}