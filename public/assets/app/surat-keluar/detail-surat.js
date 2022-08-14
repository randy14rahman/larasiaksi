function setParaf1(id){
    $.ajax({
        url: `/api/surat-keluar/${id}/paraf1`,
        method: 'put',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: (data)=>{

            if (data.status==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Berhasil paraf1.',
                });

                $('#modal-detail-surat button[data-dismiss="modal"]').trigger('click');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Gagal paraf1.',
                });
            }

        }
    });
}

function setParaf2(id){
    $.ajax({
        url: `/api/surat-keluar/${id}/paraf2`,
        method: 'put',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: (data)=>{

            if (data.status==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Berhasil paraf1.',
                });

                $('#modal-detail-surat button[data-dismiss="modal"]').trigger('click');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Gagal paraf2.',
                });
            }

        }
    });
}

function setTtd(id){
    $.ajax({
        url: `/api/surat-keluar/${id}/ttd`,
        method: 'put',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: (data)=>{

            if (data.status==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Berhasil tandatangan.',
                });

                $('#modal-detail-surat button[data-dismiss="modal"]').trigger('click');
                location.reload();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Gagal Tandatangan.',
                });
            }

        }
    });
}
