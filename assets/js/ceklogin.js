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
                $("#pesan1").fadeIn();
                $("#pesan1").html('Username atau Password Anda Salah!');
                setTimeout(function() {
                    $("#pesan1").fadeOut();
                }, 2000); //will call the function after 2 secs.
            } else {
                $("#pesan2").fadeIn();
                $("#pesan2").html('Login Berhasil..');
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