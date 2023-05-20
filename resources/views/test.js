    $('#submit-bpm').on('click', function(e) {
        e.preventDefault();
        var project = $('select[name="project_bpm"]').val();
        var wbs = $('select[name="wbs_bpm"]').val();
        var data = {
            project: project,
            wbs:wbs,
            items: itemsBpm

        };
        console.log(data);
        $.ajax({
            url: '/new-transaksi-bpm',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                Swal.fire('Data Berhasil Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
                clearAllForm();
            },
            error: function(data) {
                Swal.fire('Data Gagal Ditambahkan').then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/transaksi';
                    }
                });
            }
        });
    });
