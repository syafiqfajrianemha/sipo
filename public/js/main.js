// flash message
const flashData = $("#flash-data").data('flashdata');

if (flashData) {
    Swal.fire({
        icon: 'success',
        title: flashData,
        showConfirmButton: true,
    });
}

// button delete
$('.form-delete').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus'
    }).then((result) => {
        if (result.value) {
            return $(this).submit();
        }
    })
});

// form attachment
$('.form-attachment button[type="submit"]').on('click', function (e) {
    e.preventDefault();

    const form = $(this).closest('form');
    const fileInput = form.find('input[type="file"]')[0];

    if (!fileInput.files.length) {
        Swal.fire({
            icon: 'error',
            title: 'File tidak ditemukan!',
            text: 'Silakan pilih file sebelum mengunggah.'
        });
        return;
    }

    Swal.fire({
        title: 'Upload Bukti Pengiriman?',
        text: 'Pastikan file yang diunggah sudah benar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Upload',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// button diterima
$('.form-diterima').on('click', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Apakah Anda Sudah Menerimanya?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Sudah'
    }).then((result) => {
        if (result.value) {
            return $(this).submit();
        }
    })
});
