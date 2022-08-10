$(() => {
    var dataa = [{
        'judul': 'Perjalanan Dinas',
        'perihal': 'Surat Tugas',
        'tanggal': 'Aug 4, 2022',
        'action': 'liat file',
        'status': 'Diproses',
        'delete': 'delete'
    }]

    datatable = $('#datatable-surat-keluar').DataTable({
        data: dataa,
        orderCellsTop: true,
        columns: [{
            data: 'judul'
        }, {
            data: 'perihal'
        }, {
            data: 'tanggal'
        }, {
            data: 'action',
            render: () => {
                return '<a href="google.com">Liat File</a>'
            }
        }, {
            data: 'status',
            render: (data, type, row) => {
                return `<div><span class="badge text-bg-primary" style="background-color:#28a745">Proses</span></div>`
            }
        }, {
            data: 'delete',
            render: (data, type, row) => {
                return `<button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fas fa-trash fa-fw"></i></button>`
            }
        }]


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
        data: formData
    });

}
