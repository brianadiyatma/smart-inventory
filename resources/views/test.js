$('#material').on('change', function (e) {
    e.preventDefault();
    var material = $(this).val();

    $.ajax({
        url: '/get-uom/' + material,
        type: 'GET',
        success: function (data) {
            console.log(data);
            $('select[name="uom"]').empty();
            $.each(data.data, function (key, value) {
                $('select[name="uom"]').append('<option value="' + value.id + '">' + value.uom_name + ' : ' + value.uom_code + '</option>');
            });
        },
        error: function () {
            Swal.fire('Data Gagal Tidak Ditemukan ').then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/new-transaksi';
                }
            });
        }
    })
 })
