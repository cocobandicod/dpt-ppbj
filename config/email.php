<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//ini sesuaikan foldernya ke file 3 ini
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function kirim_email($email, $judul, $pesan)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'no.reply.pesan@gmail.com';                     //SMTP username
        $mail->Password   = 'vujeegykgapaptfg';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //pengirim
        $mail->setFrom('no.reply.pesan@gmail.com', 'dpt-ppbj UNG');
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $judul;
        $mail->Body    = $pesan;
        $mail->AltBody = '';
        //$mail->AddEmbeddedImage('gambar/logo.png', 'logo'); //abaikan jika tidak ada logo
        //$mail->addAttachment(''); 

        $mail->send();
        //return 'Email Terkirim';
    } catch (Exception $e) {
        //return "Email Tidak Terkirim {$mail->ErrorInfo}";
    }
}

function template($username, $pass, $link)
{
    $template = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Aktivasi Akun Penyedia</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 14px;
                line-height: 1.5;
                color: #333;
                padding: 20px;
                background-color: #f5f5f5;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 30px;
                color: #333;
                text-align: center;
            }
            .container {
                max-width: 700px;
                margin: 0 auto;
                background-color: #fff;
                padding: 30px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            p {
                margin-bottom: 20px;
            }
            .btn {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                font-weight: bold;
                text-decoration: none;
                color: #fff;
                background-color: #007bff;
                border-radius: 5px;
            }
            b {
                font-size: large;
            }
        </style>
    </head> 
    <body>
        <h1>Aktivasi Akun Penyedia</h1>
        <div class="container">
            <img src="https://dpt.ppbj.ung.ac.id/assets/images/logo-dark.png">
            <p>Terima kasih telah mendaftar</p>
            <p>Berikut adalah detail informasi login Anda:</p>
            <ul>
                <li>Username: <b>' . $username . '</b>
                </li>
                <li>Password: <b>' . $pass . '</b>
                </li>
            </ul>
            <p>Untuk dapat menggunakan akun Anda, silahkan klik tombol di bawah ini untuk mengaktivasi akun:</p>
            <a href="' . $link . '" class="btn">Aktivasi Akun</a>
            <p>Jika tombol di atas tidak dapat di klik, Anda dapat menyalin tautan di bawah ini dan memasukannya ke dalam alamat URL di browser:</p>
            <p><a href="' . $link . '">' . $link . '</a></p>
            <p>Pesan ini telah dihasilkan oleh sistem secara otomatis. pastikan anda tidak membalas pesan ini</p>
            <p>Terima Kasih.</p>
        </div>
    </body>
    </html>    
';
    return $template;
}
