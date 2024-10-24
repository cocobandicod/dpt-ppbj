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

function reset_email($email, $judul, $pesan)
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

function undangan_email($email, $judul, $pesan)
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

function template_reset($username, $pass, $email)
{
  $template = '
 <table
  width="100%"
  height="100%"
  style="min-width: 348px"
  border="0"
  cellspacing="0"
  cellpadding="0"
  lang="en">
  <tbody>
    <tr height="32" style="height: 32px">
      <td></td>
    </tr>
    <tr align="center">
      <td>
        <div>
          <div></div>
        </div>
        <table
          border="0"
          cellspacing="0"
          cellpadding="0"
          style="padding-bottom: 20px; max-width: 516px; min-width: 220px">
          <tbody>
            <tr>
                <td width="8" style="width: 8px"></td>
                <td>
                  <div
                    style="
                      border-style: solid;
                      border-width: thin;
                      border-color: #dadce0;
                      border-radius: 8px;
                      padding: 40px 20px;
                    "
                    align="center"
                    class="m_23551070794751244mdv2rw">
                    <img
                      src="https://dpt.ppbj.ung.ac.id/assets/images/logo-dark.png"
                      height="30"
                      aria-hidden="true"
                      style="margin-bottom: 16px"
                      alt="Google"
                      class="CToWUd"
                      data-bit="iit" />
                    <div
                      style="
                        font-family: "Google Sans", Roboto, RobotoDraft, Helvetica, Arial,
                          sans-serif;
                        border-bottom: thin solid #dadce0;
                        color: rgba(0, 0, 0, 0.87);
                        line-height: 32px;
                        padding-bottom: 24px;
                        text-align: center;
                        word-break: break-word;
                      ">
                      <div style="font-size: 24px">Reset Password Penyedia</div>
                      <table align="center" style="margin-top: 8px">
                        <tbody>
                          <tr style="line-height: normal">
                            <td>
                              <a
                                style="
                                  font-family: "Google Sans", Roboto, RobotoDraft,
                                    Helvetica, Arial, sans-serif;
                                  color: rgba(0, 0, 0, 0.87);
                                  font-size: 14px;
                                  line-height: 20px;
                                "
                                >' . $email . '</a
                              >
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div
                      style="
                        font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                        font-size: 14px;
                        color: rgba(0, 0, 0, 0.87);
                        line-height: 20px;
                        padding-top: 20px;
                        text-align: center;
                      ">
                      Terima kasih telah melakukan reset password Berikut adalah detail
                      informasi login baru Anda:
                      <div style="padding-top: 12px; text-align: center">
                        <p>
                          Username: <b>' . $username . '</b><br />
                          Password: <b>' . $pass . '</b>
                        </p>
                      </div>
                      Silahkan login kembali dengan password yang baru pada halaman
                      https://dpt.ppbj.ung.ac.id/
                    </div>
                  </div>
                  <div style="text-align: left">
                    <div
                      style="
                        font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                        color: rgba(0, 0, 0, 0.54);
                        font-size: 11px;
                        line-height: 18px;
                        padding-top: 12px;
                        text-align: center;
                      ">
                      <div>
                        Pesan ini telah dihasilkan oleh sistem secara otomatis. pastikan
                        anda tidak membalas pesan ini. Terima Kasih
                      </div>
                      <div style="direction: ltr">
                        © UPPBJ Badan Layanan Umum Universitas Negeri Gorontalo,<br />
                        <a
                          class="m_23551070794751244afal"
                          style="
                            font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                            color: rgba(0, 0, 0, 0.54);
                            font-size: 11px;
                            line-height: 18px;
                            padding-top: 12px;
                            text-align: center;
                          "
                          >Jalan Jenderal Sudirman No. 6 Kota Gorontalo</a
                        >
                      </div>
                    </div>
                  </div>
                </td>
                <td width="8" style="width: 8px"></td>
              </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr height="32" style="height: 32px">
      <td></td>
    </tr>
  </tbody>
</table>
';
  return $template;
}

function template_undangan($judul, $isi, $email, $file, $url)
{
  if (empty($file)) {
    $download = '';
  } else {
    $download = '
    <div
    style="padding-top:32px;text-align:center">
    <a href="' . $url . 'berkas/' . $file . '"
    style="font-family:Google Sans,Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:16px;color:#ffffff;font-weight:400;text-decoration:none;font-size:14px;display:inline-block;padding:10px 24px;background-color:#4184f3;border-radius:5px;min-width:90px"
    target="_blank">Download File Undangan</a></div>
    ';
  }
  $template = '
 <table
  width="100%"
  height="100%"
  style="min-width: 348px"
  border="0"
  cellspacing="0"
  cellpadding="0"
  lang="en">
  <tbody>
    <tr height="32" style="height: 32px">
      <td></td>
    </tr>
    <tr align="center">
      <td>
        <div>
          <div></div>
        </div>
        <table
          border="0"
          cellspacing="0"
          cellpadding="0"
          style="padding-bottom: 20px; max-width:100%; min-width: 720px">
          <tbody>
            <tr>
                <td width="8" style="width: 8px"></td>
                <td>
                  <div
                    style="
                      border-style: solid;
                      border-width: thin;
                      border-color: #dadce0;
                      border-radius: 8px;
                      padding: 40px 20px;
                    "
                    align="center"
                    class="m_23551070794751244mdv2rw">
                    <img
                      src="https://dpt.ppbj.ung.ac.id/assets/images/logo-dark.png"
                      height="30"
                      aria-hidden="true"
                      style="margin-bottom: 16px"
                      alt="Google"
                      class="CToWUd"
                      data-bit="iit" />
                    <div
                      style="
                        font-family: Google Sans, Roboto, RobotoDraft, Helvetica, Arial,
                          sans-serif;
                        border-bottom: thin solid #dadce0;
                        color: rgba(0, 0, 0, 0.87);
                        line-height: 32px;
                        padding-bottom: 24px;
                        text-align: center;
                        word-break: break-word;
                      ">
                      <div style="font-size: 18px">' . $judul . '</div>
                      <table align="center" style="margin-top: 8px">
                        <tbody>
                          <tr style="line-height: normal">
                            <td>
                              <a
                                style="
                                  font-family: Google Sans, Roboto, RobotoDraft,
                                    Helvetica, Arial, sans-serif;
                                  color: rgba(0, 0, 0, 0.87);
                                  font-size: 14px;
                                  line-height: 20px;
                                "
                                >' . $email . '</a
                              >
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div
                      style="
                        font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                        font-size: 14px;
                        color: rgba(0, 0, 0, 0.87);
                        line-height: 20px;
                        padding-top: 20px;
                        text-align: center;
                      ">
                      ' . $isi . '
                      ' . $download . '
                    </div>
                  </div>
                  <div style="text-align: left">
                    <div
                      style="
                        font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                        color: rgba(0, 0, 0, 0.54);
                        font-size: 11px;
                        line-height: 18px;
                        padding-top: 12px;
                        text-align: center;
                      ">
                      <div>
                        Pesan ini telah dihasilkan oleh sistem secara otomatis. pastikan
                        anda tidak membalas pesan ini. Terima Kasih
                      </div>
                      <div style="direction: ltr">
                        © UPPBJ Badan Layanan Umum Universitas Negeri Gorontalo,<br />
                        <a
                          class="m_23551070794751244afal"
                          style="
                            font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
                            color: rgba(0, 0, 0, 0.54);
                            font-size: 11px;
                            line-height: 18px;
                            padding-top: 12px;
                            text-align: center;
                          "
                          >Jalan Jenderal Sudirman No. 6 Kota Gorontalo</a
                        >
                      </div>
                    </div>
                  </div>
                </td>
                <td width="8" style="width: 8px"></td>
              </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr height="32" style="height: 32px">
      <td></td>
    </tr>
  </tbody>
</table>
';
  return $template;
}
