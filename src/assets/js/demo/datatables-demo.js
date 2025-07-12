$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            lengthMenu: "Tampilkan _MENU_",
            search: "Pencarian:",
            paginate: {
                previous: "<<",
                next: ">>"
            },
            zeroRecords: "Tidak ditemukan data yang sesuai",
            info: "",
            infoEmpty: "",
            infoFiltered: ""
        }
    });

    // Tambah styling
    $('.dataTables_wrapper .dataTables_filter').addClass('text-right mb-2');
    $('.dataTables_wrapper .dataTables_length').addClass('text-left mb-2 d-none d-md-block');
    $('.dataTables_wrapper .dataTables_paginate').addClass('d-flex justify-content-center mt-3');

    // Sembunyikan .dataTables_info sepenuhnya
    $('.dataTables_wrapper .dataTables_info').hide();
});