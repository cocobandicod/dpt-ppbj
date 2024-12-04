var scriptElement = document.currentScript;
var URL = scriptElement.dataset.url;

$('#myModal').on('show.bs.modal', function(e) {
	var rowid = $(e.relatedTarget).data('id');
	var act = $(e.relatedTarget).data('act');
	//menggunakan fungsi ajax untuk pengambilan data
	$.ajax({
		type: 'post',
		url: URL + 'form/permintaan/user',
		data: {
			id: rowid,
			act: act
		},
		success: function(data) {
			$('.fetched-data').html(data); //menampilkan data ke dalam modal
		},
	});
});

var dataTable
        $(document).ready(function() {
            dataTable = $('#DTable').DataTable({
                stateSave: true,
                autoWidth: true,
                processing: true,
                ordering: false,
                responsive: false,
                dom: "lBfrtip",
                buttons: [{
                        extend: 'excel',
                        text: '<i class="ri-file-excel-line fs-14 me-1"></i>Excel'
                    },
                    {
                        text: '<i class="ri-refresh-line fs-14 me-1"></i>Reload',
                        action: function(e, dt, node, config) {
                            dataTable.ajax.reload(null, false);
                        }
                    }
                ],
                language: {
                    processing: '<span><i class="mdi mdi-spin mdi-loading me-1"></i> Memuat Data..</span>',
                    search: '<span>Cari:</span> _INPUT_',
                    searchPlaceholder: 'Masukan kata kunci...',
                },
                columnDefs: [{
                        className: 'text-center p-2',
                        width: '3%',
                        targets: [0, 1]
                    },
                    {
                        className: 'text-center p-2',
                        targets: [2]
                    },
                    {
                        className: 'text-center p-2',
                        width: '15%',
                        targets: [3]
                    },
                    {
                        className: 'text-end p-2',
                        targets: [7, 8]
                    },
                    {
                        className: 'text-center p-2',
                        targets: [5, 6, 9, 10]
                    },
                    {
                        className: 'p-2',
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    },
                ],
                "ajax": {
                    url: URL + "tabel/permintaan/user",
                    type: "post"
                }
            });
        });

		$(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: URL + 'proses/permintaan/user',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: nilai,
                beforeSend: function() {
                    document.querySelector('#simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                },
                success: function(data) {
                    if (data === 'gagal') {
                        Toastify({
                            text: "Data Gagal Dimasukan!",
                            className: "bg-danger",
                            gravity: "top",
                            position: "right",
                            duration: 3000,
                        }).showToast();
                    } else {
                        Toastify({
                            text: "Data Berhasil Dimasukan!",
                            gravity: "top",
                            position: "right",
                            duration: 3000
                        }).showToast();
                        $('#myModal').modal('toggle');
                        dataTable.ajax.reload(null, false);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Toastify({
                        text: "Data Gagal Dimasukan!",
                        className: "bg-danger",
                        gravity: "top",
                        position: "right",
                        duration: 3000
                    }).showToast();
                },
                complete: function(data) {
                    document.querySelector('#simpan').innerHTML = '<i class="ri-save-3-line align-middle ms-1"></i> Simpan';
                }
            });
        });

		$(document).on('click', '#del', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var del = $(e.currentTarget).data('id');
            var act = $(e.currentTarget).data('act');
            Swal.fire({
                title: "Data ini akan dihapus?",
                text: nama,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-primary w-xs mt-2",
                confirmButtonText: "Hapus!",
                cancelButtonText: "Batal!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: URL + 'proses/permintaan/user',
                        data: {
                            del: del,
                            act: act
                        },
                        success: function(data) {
                            dataTable.ajax.reload(null, false);
                            Toastify({
                                text: "Data Berhasil Dihapus!",
                                gravity: "top",
                                position: "right",
                                duration: 3000
                            }).showToast();
                        }
                    });
                }
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }

        function validasiFile(inputFile) {
            var pathFile = inputFile.value;
            var ekstensiOk = /(\.pdf|\.jpg|\.jpeg|\.docx)$/i;
            var file_size = inputFile.files[0].size;

            if (!ekstensiOk.exec(pathFile)) {
                alert('Silakan upload file yang memiliki ekstensi .pdf .jpg .jpeg .docx');
                inputFile.value = '';
                return false;
            } else {
                if (file_size > 10000000) {
                    alert('Ukuran file harus kurang dari 10mb');
                    inputFile.value = '';
                    return false;
                }
            }
        }
