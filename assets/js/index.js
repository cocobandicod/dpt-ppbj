$('#login').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'proses/login',
        dataType: "JSON",
        data: $(this).serialize(),
        beforeSend: function() {
            document.querySelector('#tblmasuk').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
        },
        success: function(data) {
            if (data.status === 'konfirmasi') {
                $(".login-danger").fadeIn();
                $(".login-danger").html('Gagal! Anda belum melakukan aktivasi pendaftaran');
                setTimeout(function() {
                    $(".login-danger").fadeOut();
                }, 2000); //will call the function after 2 secs.
            } else if (data.status === 'gagal') {
                $(".login-danger").fadeIn();
                $(".login-danger").html('Gagal! username atau password anda salah');
                setTimeout(function() {
                    $(".login-danger").fadeOut();
                }, 2000); //will call the function after 2 secs.
            } else {
                $(".login-danger").fadeOut();
                $(".login-success").fadeIn();
                $(".login-success").html('Login Berhasil..');
                setTimeout(function() {
                    document.cookie = 'token' + "=" + data + "secure";
                    window.location = data.status;
                }, 800); //will call the function after 2 secs. 
            }
        },
        complete: function(data) {
            document.querySelector('#tblmasuk').innerHTML = 'Masuk';
        }
    });
});

function kirim_email(username, email, token, akses) {
    $.ajax({
        type: 'post',
        dataType: "JSON",
        url: 'proses/email',
        data: {
            username: username,
            email: email,
            token: token,
            akses: akses
        },
        success: function(data) {
            console.log('Send Email Sukses');
        }
    });
}

$('#daftar').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'proses/daftar',
        dataType: "JSON",
        data: $(this).serialize(),
        beforeSend: function() {
            document.querySelector('#tbldaftar').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
        },
        success: function(data) {
            if (data.status == 'alert_captcha') {
                $(".alert-kode").fadeIn();
                $('.alert-kode').html('Captcha yang dimasukan salah');
                setTimeout(function() {
                    $(".alert-kode").fadeOut();
                }, 5000);
            } else if (data.status == 'alert_user') {
                $(".alert-user").fadeIn();
                $('.alert-user').html('Username "' + data.user + '" sudah ada yang gunakan');
                setTimeout(function() {
                    $(".alert-user").fadeOut();
                }, 5000);
            } else if (data.status == 'alert_email') {
                $(".alert-email").fadeIn();
                $('.alert-email').html('email "' + data.email + '" ini sudah terdaftar');
                setTimeout(function() {
                    $(".alert-email").fadeOut();
                }, 5000);
            } else if (data.status == 'sukses') {
                $('#daftar').addClass('kunci');
                $('#pesan').removeClass('kunci');
                $('.mail').html(data.email);
                kirim_email(data.username, data.email, data.token, data.akses);
            }
        },
        complete: function(data) {
            document.querySelector('#tbldaftar').innerHTML = '<i class="ri-save-2-fill me-1 align-middle"></i> Ajukan Pendaftaran';
        }
    });
});