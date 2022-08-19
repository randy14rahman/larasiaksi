$(() => {
    bsCustomFileInput.init();
    
    getListSurat()

    $('#form-surat-masuk').validate({
        rules: {
            tanggal_surat: {
                required: true,
            },
            perihal_surat: {
                required: true
            },
            nomor_surat: {
                required: true,
            },
            asal_surat: {
                required: true,
            },
            jenis_surat_masuk: {
                required: true,
            },
            ditugaskan_ke: {
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
            submitSurat($(form));
        }
    });



    var data_disposisi = [{
        'posisi': 'Andi',
        'jabatan': 'Eselon 3',
        'from': 'Robinson',
        'jabatan_pen': 'KA OPD',
        'status': 'process',
        'tgl': 'Aug 1 , 2022',
        'no': '12345'
    }

    ]

    datatable = $('#datatable-disposisi').DataTable({
        data: data_disposisi,
        orderCellsTop: true,
        columns: [{
            data: 'posisi'
        }, {
            data: 'jabatan'
        }, {
            data: 'from'
        }, {
            data: 'jabatan_pen'
        }, {
            data: 'status',
            render: (data, type, row) => {
                return `<div><span class="badge text-bg-primary" style="background-color:#198754">Process</span></div>`
            }
        }, {
            data: 'tgl'
        }, {
            data: 'no'
        }]


    });

    // $('#form-add-user').on('submit', (e)=>{
    //     e.preventDefault();
    //     addUser($(e.currentTarget));
    // });
    // $('#form-edit-user').on('submit', (e)=>{
    //     e.preventDefault();

    //     const user_id = parseInt($(e.currentTarget).find('input[name="id"]').val());
    //     editUser($(e.currentTarget), user_id);
    // });

    // $('#modal-add-user').on('show.bs.modal', (e)=>{
    //     $('#form-add-user button[type="submit"]').prop('disabled', false);
    //     $('#form-add-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Create');
    // });
    // $('#modal-edit-user').on('show.bs.modal', (e)=>{
    //     $('#form-edit-user button[type="submit"]').prop('disabled', false);
    //     $('#form-edit-user button[type="submit"]').removeClass('btn-success btn-secondary').addClass('btn-primary').text('Update');
    // });
    // $('#datatable-1 tbody').on('click', '.btn-edit', function (e) {

    //     const data = datatable.row($(this).parents('tr')).data();
    //     // console.log(data);
    //     $('#form-edit-user .btn-submit').attr('data-id', data.id);
    //     $('#form-edit-user input[name="id"]').val(data.id);
    //     $('#form-edit-user input[name="nip"]').val(data.nip);
    //     $('#form-edit-user input[name="name"]').val(data.name);
    //     $('#form-edit-user input[name="jabatan"]').val(data.jabatan);
    //     $('#form-edit-user input[name="email"]').val(data.email);
    //     $('#form-edit-user input[name="password"]').val(data.password);
    //     $('#form-edit-user input[name="is_pemaraf"]').prop('checked', (data.is_pemaraf==1));
    //     $('#form-edit-user input[name="is_pettd"]').prop('checked', (data.is_pettd==1));
    //     $('#form-edit-user select[name="role"]').val(data.role_id);
    // });

    // $('#datatable-1 tbody').on('click', '.btn-delete', (e)=>{
    //     const user_id = parseInt($(e.currentTarget).data('id'));
    //     console.log(user_id);
    //     Swal.fire({
    //     title: 'Are you sure?',
    //     text: "You won't be able to revert this!",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     cancelButtonColor: '#3085d6',
    //     confirmButtonColor: '#d33',
    //     confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             deleteUser(user_id);
    //         }
    //     })
    // })

});

function getListSurat() {

    var datatable = $('#datatable-surat').DataTable({
        ajax: '/api/surat-masuk',
        orderCellsTop: true,
        bDestroy: true,
        order: [[4, 'desc']],
        columns: [{
            title: 'Jenis Surat',
            data: 'jenis_surat_masuk'
        }, {
            title: 'Perihal',
            data: 'perihal_surat'
        }, {
            title: 'Tanggal Surat',
            data: 'tanggal_surat'
        }, {
            title: 'Status',
            data: 'status',
            render: (data, type, row) => {

                let _status = `<span class="badge badge-danger" >Surat Masuk</span><br/>${row.assign_to.name}`;
                if (row.is_proses==1) {
                    _status = `<span class="badge badge-primary">Diproses</span><br/>${row.pemroses.name}`;
                } else if (row.is_disposisi==1) {
                    _status = `<span class="badge badge-info">Disposisi ${row.disposisi.length}</span><br/>${row.disposisi[0].target_disposisi.name}`;
                }
                return _status;
            }
        }, {
            title: 'Dibuat oleh',
            data: 'created_at',
            render: (data, type, row)=>{
                return `${row.created_by_name}<br/>${row.created_at}`;
            }
        }, {
            title: 'Action',
            sortable: false,
            render: (data, type, row) => {
                return `
                    <a class="btn btn-sm btn-primary" href="/surat-masuk/detail/${row.id}"><i class="fa-duotone fa-eye"></i> Lihat</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}"><i class="fa-duotone fa-trash"></i></button>
                `
            }
        }]


    });

}

function submitSurat(form) {
    var formData = new FormData();
    formData.append('_token', form.find('input[name="_token"]').val());
    formData.append('tanggal_surat', form.find('input[name="tanggal_surat"]').val())
    formData.append('asal_surat', form.find('input[name="asal_surat"]').val())
    formData.append('perihal_surat', form.find('input[name="perihal_surat"]').val())
    formData.append('nomor_surat', form.find('input[name="nomor_surat"]').val())
    formData.append('jenis_surat_masuk', form.find('select[name="jenis_surat_masuk"]').val())
    formData.append('file', $('input[type=file]')[0].files[0]);
    formData.append('ditugaskan_ke', form.find('select[name="ditugaskan_ke"]').val());

    $.ajax({
        url: '/api/surat-masuk',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
            const spinner = ' <div class = "ml-2 spinner-border text-light spinner-grow-sm"' +
                'role = "status" id = "spinner-loading" ><span class = "sr-only"id = "spinner-loading" > Loading... < /span> < /div > ';

            $(".btn-submit-surat-masuk").append(spinner)

        },
        error: () => {

        },
        complete: () => {
            $("#spinner-loading").remove()
        },
        success: (res) => {

            if (res.transaction) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Surat Masuk Berhasil di Tugaskan',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#form-surat-masuk").trigger("reset");
                        getListSurat()
                    }
                });
            }
        }
    })
}
