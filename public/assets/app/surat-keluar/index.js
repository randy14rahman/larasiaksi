$(() => {
    bsCustomFileInput.init();

    datatable = $('#datatable-surat-keluar').DataTable({
        ajax: `/api/surat-keluar`,
        orderCellsTop: true,
        columns: [{
            title: 'Perihal',
            data: 'perihal_surat'
        }, {
            title: 'Judul Surat',
            data: 'judul_surat'
        }, {
            title: 'Tanggal Surat',
            data: 'tanggal_surat'
        }, {
            title: 'Status',
            render: (data, type, row)=>{

                let status = ``;
                status += (row.is_paraf1==1) ?  `<span class="badge badge-success">Sudah diparaf 1</span>` : `<span class="badge badge-danger">Belum diparaf 1</span>`;
                if (row.pemaraf2!=null) {
                    status += (row.is_paraf2==1) ? ` <span class="badge badge-success">Sudah diparaf 2</span>` : ` <span class="badge badge-danger">Belum diparaf 2</span>`;
                }
                
                status += (row.is_ttd==1) ? ' <span class="badge badge-success">Sudah Ditandatangani</span>' : ` <span class="badge badge-danger">Belum ditandatangan</span>`;

                return status;
            }
        }, {
            title: 'Dibuat oleh',
            data: 'created_by_name',
            render: (data,type,row)=>{
                return `${data}<br>${row.created_at}`
            }
        }, {
            sortable: false,
            render: (data, type, row) => {
                return `
                    <button class="btn btn-sm btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail-surat"><i class="fas fa-eye fa-fw"></i> Lihat</button>
                `
            }
        }]


    });

    $('#datatable-surat-keluar tbody').on('click', '.btn-detail', function (e) {
        const data = datatable.row($(this).parents('tr')).data();
        // console.log(data);

        $('#modal-detail-surat dd>span#detail-perihal').text(data.perihal_surat);
        $('#modal-detail-surat dd>span#detail-judul_surat').text(data.judul_surat);
        $('#modal-detail-surat dd>span#detail-tanggal_surat').text(data.tanggal_surat);

        $('#modal-detail-surat .pemaraf1>address').children('span').eq(0).text(`${data.pemaraf1.name}`);
        $('#modal-detail-surat .pemaraf1>address').children('span').eq(1).text(`${data.pemaraf1.nip}`);
        $('#modal-detail-surat .pemaraf1>address').children('span').eq(2).text(`${data.pemaraf1.jabatan}`);
        let _areaParaf1 = '<p class="my-0"><span class="badge badge-danger">Belum diparaf</span></p>';
        if ((data.is_paraf1==null || data.is_paraf1==0) && user_id==data.pemaraf1.id){
            _areaParaf1 = `
                <a href="#" class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setParaf1(${data.id});">Paraf,<br>Klik disini</a>
            `;
        } else if (data.is_paraf1==1){
            _areaParaf1 = `<p class="my-0"><span class="badge badge-success">Sudah diparaf<br>${data.paraf1_date}</p>`;
        }
        $('#modal-detail-surat .pemaraf1>address>div').html(_areaParaf1);

        $('#modal-detail-surat .pemaraf2').addClass('d-none');
        if (data.pemaraf2!=null) {
            $('#modal-detail-surat .pemaraf2').removeClass('d-none');
            $('#modal-detail-surat .pemaraf2>address').children('span').eq(0).text(`${data.pemaraf2.name}`);
            $('#modal-detail-surat .pemaraf2>address').children('span').eq(1).text(`${data.pemaraf2.nip}`);
            $('#modal-detail-surat .pemaraf2>address').children('span').eq(2).text(`${data.pemaraf2.jabatan}`);
            let _areaParaf2 = '<p class="my-0"><span class="badge badge-danger">Belum diparaf</span></p>';
            if ((data.is_paraf2==null || data.is_paraf2==0) && user_id==data.pemaraf2.id){
                _areaParaf2 = `
                    <button class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setParaf2(${data.id});">Paraf,<br> Klik disini</button>
                `;
            } else if (data.is_paraf2==1){
                _areaParaf2 = `<p class="my-0"><span class="badge badge-success">Sudah diparaf<br>${data.paraf2_date}</p>`;
            }
            $('#modal-detail-surat .pemaraf2>address>div').html(_areaParaf2);
        }

        $('#modal-detail-surat .pettd>address').children('span').eq(0).text(`${data.pettd.name}`);
        $('#modal-detail-surat .pettd>address').children('span').eq(1).text(`${data.pettd.nip}`);
        $('#modal-detail-surat .pettd>address').children('span').eq(2).text(`${data.pettd.jabatan}`);
        let _areaTtd = '<p class="my-0"><span class="badge badge-danger">Belum ditandatangan</span></p>';
        if ((data.is_ttd==null || data.is_ttd==0) && user_id==data.pettd.id){
            const isDisabled = (data.is_paraf1==null||data.is_paraf1==0) ? ' disabled="disabled"' : '';
            _areaTtd = `<button class="btn btn-app bg-primary m-0" onclick="event.preventDefault(); setTtd(${data.id});"${isDisabled}>Tanda tangan,<br>Klik disini</button>`;
        } else if (data.is_ttd==1){
            _areaTtd = `<p class="my-0"><span class="badge badge-success">Sudah ditandatangan<br>${data.ttd_date}</p>`;
        }
        $('#modal-detail-surat .pettd>address>div').html(_areaTtd);

        PDFObject.embed(`${data.link_surat||'/file-not-found'}#toolbar=0`, "#show-pdf", {
            height: '775px'
        });
    });

    $('#pettd').on('change', getPemaraf);

    $('#form-add-surat-keluar').validate({
        rules: {
            tanggal_surat: {
                required: true,
            },
            perihal: {
                required: true
            },
            nomor_surat: {
                required: true,
            },
            judul_surat: {
                required: true,
            },
            pettd: {
                required: true,
            },
            pemaraf1: {
                required: true,
            },
            file: {
                required: true,
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            addSuratKeluar($(form));
        }
    });

});

function getPemaraf(e){

    $('select.form-control.pemaraf').html('<option value="">Pilih Pemaraf</option>');

    const user_id = $(e.currentTarget).find('option:selected').val();
    $.ajax({
        url: `/api/get-pemaraf/${user_id}/user`,
        success: (data)=>{
            if (data){
                $.each(data, (k,v)=>{
                    $('select.form-control.pemaraf').append(`<option value="${v.id}">${v.nip} | ${v.name} | ${v.jabatan}</option>`);
                });
            }

        }
    });
}

function addSuratKeluar(form){

    var formData = new FormData();
    formData.append('_token', form.find('input[name="_token"]').val());
    formData.append('tanggal_surat', form.find('input[name="tanggal_surat"]').val());
    formData.append('perihal', form.find('input[name="perihal"]').val());
    formData.append('nomor_surat', form.find('input[name="nomor_surat"]').val());
    formData.append('judul_surat', form.find('input[name="judul_surat"]').val());
    formData.append('pettd', form.find('select[name="pettd"]').val());
    formData.append('pemaraf1', form.find('select[name="pemaraf1"]').val());
    formData.append('pemaraf2', form.find('select[name="pemaraf2"]').val());

    formData.append('file', $('input[type=file]')[0].files[0]);
    formData.append('user_id', user_id);

    $.ajax({
        url: '/api/surat-keluar',
        method: 'post',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: ()=>{
            $('#form-add-surat-keluar button[type="submit"]').html('<i class="fas fa-sync-alt fa-spin">');
            $('#form-add-surat-keluar button[type="submit"]').prop('disabled', true);
        },
        success: (data)=>{

            if (data.status==1){
                Swal.fire({
                    icon: 'success',
                    title: 'Good Job!',
                    text: 'Berhasil membuat Surat Keluar.',
                });

                form.trigger('reset');
                datatable.ajax.reload();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Gagal membuat Surat Keluar.',
                });
            }
            $('#form-add-surat-keluar button[type="submit"]').html('Buat Surat');
            $('#form-add-surat-keluar button[type="submit"]').prop('disabled', false);
        }
    });

}

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
                datatable.ajax.reload();
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
                datatable.ajax.reload();
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
                datatable.ajax.reload();
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
