$(() => {

    datatable = $('#datatable-arsip-surat-masuk').DataTable({
        ajax: `/api/surat-masuk/arsip`,
        orderCellsTop: true,
        columns: [{
            title: 'Jenis Surat',
            data: 'jenis_surat_masuk',
            class: 'valign-middle',
        }, {
            title: 'Perihal',
            data: 'perihal_surat',
            class: 'valign-middle',
        }, {
            title: 'Tanggal Surat',
            data: 'tanggal_surat',
            class: 'valign-middle',
        }, {
            title: 'Dibuat oleh',
            data: 'created_by_name',
            class: 'valign-middle',
            render: (data,type,row)=>{
                return `${data}<br>${row.created_at}`
            }
        }, {
            sortable: false,
            class: 'valign-middle',
            render: (data, type, row) => {
                return `
                    <a href="${row.link_file}" class="btn btn-sm btn-primary btn-detail" target="blank"><i class="fas fa-download fa-fw"></i> Lihat / Unduh / Bagikan</a>
                `
            }
        }]


    });

    $('#datatable-arsip-surat-masuk tbody').on('click', '.btn-detail', function (e) {
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

        PDFObject.embed(`${data.link_surat}`, "#show-pdf", {
            height: '775px'
        });
    });
});