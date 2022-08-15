console.log(window.location.origin+url_id)
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

async function setTtd(id){
    $('.btn-app').html('<i class="fas fa-sync-alt fa-spin">');

    const src = window.location.origin+url_id
    const split = url_id.split('/')
    const fileName = 'ttd-'+split[3]
    const content =$('meta[name="csrf-token"]').attr('content')

    const res = await fetch(src);
    const buf = await res.arrayBuffer();
    const formData = new File([buf], fileName, { type: 'application/pdf' });
    const apiKey = 'rizal.prasetya11@gmail.com_41fb0457f6dad810c15a8e83e0d178562cac42dc983c20027675c27f3d27220b77d12531';
    const signatureImageUrl= 'https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='+src;

    $.ajax({
        url: 'https://api.pdf.co/v1/file/upload/get-presigned-url?name=test.pdf&contenttype=application/pdf&encrypt=true',
        beforeSend: () => {
            // $('.btn-app').html('<i class="fas fa-sync-alt fa-spin">');
        },
        type: 'GET',
        headers: { 'x-api-key': apiKey }, // passing our api key
        success: function (result) {

            if (result['error'] === false) {
                console.log(result);
                var presignedUrl = result['presignedUrl']; // reading provided presigned url to put our content into
                var uploadedUrl = result['url']; // Uploaded URL

                $("#status").html('Uploading... &nbsp;&nbsp;&nbsp; <img src="ajax-loader.gif" />');

                $.ajax({
                    url: presignedUrl, // no api key is required to upload file
                    type: 'PUT',
                    headers: { 'content-type': 'application/pdf' }, // setting to pdf type as we are uploading pdf file
                    data: formData,
                    processData: false,
                    success: function (result) {

                        // PDF.co API URL
                        var cUrl = 'https://api.pdf.co/v1/pdf/edit/add';

                        // Input data
                        var data = {
                            name: 'result.pdf',
                            url: uploadedUrl,
                            images: [
                                {
                                    url: signatureImageUrl,
                                    x: 450,
                                    y: 750,
                                    width: 119,
                                    height: 60
                                }
                            ]
                        };

                        console.log(data);

                        $("#status").html('Processing... &nbsp;&nbsp;&nbsp; <img src="ajax-loader.gif" />');
                        $.ajax({
                            url: cUrl,
                            type: 'POST',
                            headers: { 'x-api-key': apiKey, 'Content-Type': 'application/json' },
                            data: JSON.stringify(data),
                            processData: false,
                            contentType: false,
                            //data: oData,
                            success: function (result) {
                                $("#status").text('done processing.');

                                if (result.error) {
                                    $("#errorBlock").show();
                                    $("#errors").text(result.message);
                                } else {
                                    $("#resultBlock").show();
                                    $("#inlineOutput").text(JSON.stringify(result));
                                    $("#display-pdf").prop("src", result.url);
                                    $.ajax({
                                        url: `/api/surat-keluar/${id}/ttd`,
                                        method: 'put',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: (data)=>{

                                            $("#container-btn-ttd").html(' <span class="badge badge-success mt-3">Sudah ditandatangan</span>')

                                            if (data.status==1){
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Good Job!',
                                                    text: 'Berhasil tandatangan.',
                                                });

                                                $('#modal-detail-surat button[data-dismiss="modal"]').trigger('click');
                                                // location.reload();
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
                            }
                        });

                    },
                    error: function () {
                        $("#status").text('error');
                    }
                });
            }
        }
    });
    // $.ajax({
    //     url: `/api/surat-keluar/${id}/ttd`,
    //     method: 'put',
    //     data: {
    //         _token: $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: (data)=>{

    //         if (data.status==1){
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Good Job!',
    //                 text: 'Berhasil tandatangan.',
    //             });

    //             $('#modal-detail-surat button[data-dismiss="modal"]').trigger('click');
    //             location.reload();
    //         } else {
    //             Swal.fire({
    //                 icon: 'warning',
    //                 title: 'Warning!',
    //                 text: 'Gagal Tandatangan.',
    //             });
    //         }

    //     }
    // });
}
