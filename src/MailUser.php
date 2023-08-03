<?php
namespace App;

use App\ConnectDB;

class MailUser extends ConnectDB
{  
public static function mail_user($mail, $data)
    {
        extract($data);

            $mail->setFrom('admin@misionschannel.org.ng', 'Monitum Website');
            $mail->addAddress($email, 'MyDocier');
            $mail->addReplyTo("admin@misionschannel.org.ng");
            $mail->isHTML(true);
            $mail->Subject = 'Forgot Password';
            $mail->Body = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                html, body {
                        margin: 0px;
                        padding: 0px;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .thm-text {
                        color:  #ff5722;
                    }
                    .bg-dark {
                        background-color:  #000;
                    }
                    .row {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        align-items: center;
                    }
                    .col {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                    }
                    img {
                        max-width: 100%;
                    }
                    .container{
                        margin-left: auto;
                        margin-right: auto;
                        padding-left: 1rem;
                        padding-right: 1rem;
                    }
            .link {
                color: blue;
            }
                </style>
                </head>
                <body>
                    <main class="container">
                        <p>You sent a request to change your pawword! Please Click on the link below to create a new password. </p>
                        <p>'. 'www.frontend.test/reset_password.php?email=' .$email. 'code=' .uniqid() . '</b>
                        <h4><b>Thanks</b></h4>
                    </main>
                    </body>
                </html>
            ';
            $mail->AltBody = 'You sent a request to change your pawword! Please Click on the link below to create a new password.';
        
            $mail->isSMTP();
            $mail->Host = 'mail.misionschannel.org.ng';
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'admin@misionschannel.org.ng';
            $mail->Password = 'admin@misionschannel.org.ng';
            $mail->Port = 465;
        
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ),
            );
        
            if (!$mail->send()) {
                $msg = 'Mail could not be sent.';
                $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
                $mailsent = 0;
            } else {
                $msg = 'Mail Sent Successfully.';
                $mailsent = 1;
            }
            return ['mailsent' => $mailsent, 'message' => $msg];
        
    }
}