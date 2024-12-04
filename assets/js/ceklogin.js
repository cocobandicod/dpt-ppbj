// JavaScript Document
$('#login').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'cek/login',
        data: $(this).serialize(),
        beforeSend: function() {
            document.querySelector('#tblmasuk').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
        },
        success: function(data) {
            if (data === 'gagal') {
                Toastify({
                    text: "Login Gagal...",
                    className: "bg-danger",
                    gravity: "top",
                    position: "center",
                    duration: 3000,
                }).showToast();
            } else {
                Toastify({
                    text: "Login Berhasil...",
                    gravity: "top",
                    position: "center",
                    duration: 3000
                }).showToast();
                setTimeout(function() {
                    document.cookie = 'token' + "=" + data + "secure";
                    window.location = data;
                }, 500); //will call the function after 2 secs. 
            }
        },
        complete: function(data) {
            document.querySelector('#tblmasuk').innerHTML = 'Sign In';
        }
    });
});