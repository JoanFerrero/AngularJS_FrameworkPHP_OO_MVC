<?php
    class mail {
        public static function send_email($email) {
            switch ($email['type']) {
                case 'contact';
                    $email['inputSubject'] = 'Your request has been sended.';
                    $email['inputMessage'] .= "<h2>Thank $email[inputName] you for sending us an email</h2><br>";
                    $email['inputMessage'] .= "<p>You will recive an email soon answering your request.</p><br>";
                    break;
                case 'admin';
                    $email['toEmail'] = 'cuentatest172@gmail.com';
                    break;
                case 'validate';
                    $email['inputSubject'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href = 'http://localhost/AngularJS_FrameworkPHP_OO_MVC/#/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['inputSubject'] = 'Recover password';
                    $email['inputMessage'] = "<a href = 'http://localhost/AngularJS_FrameworkPHP_OO_MVC/#/recover/$email[token]'>Click here for recover your password.</a>";
                    break;
            }
            return self::send_mailjet($email);
        }
        public static function send_mailjet($email) {
            $body = [
                'Messages' => [
                    [
                    'From' => [
                        'Email' => "cuentatest172@gmail.com",
                        'Name' => "test"
                    ],
                    'To' => [
                        [
                            'Email' => $email['toEmail'],
                            'Name' => $email['toEmail']
                        ]
                    ],
                    'Subject' => $email['inputSubject'],
                    'HTMLPart' => $email['inputMessage']
                    ]
                ]
            ];
            $mailjet = parse_ini_file(MODEL_PATH . "mailjet.ini");
            $api_key0 = $mailjet['api_key0'];
            $api_key1 = $mailjet['api_key1'];

            $ch = curl_init();
              
            curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json')
            );
            curl_setopt($ch, CURLOPT_USERPWD, "$api_key0:$api_key1");
            $server_output = curl_exec($ch);
            curl_close ($ch);
              
            $response = json_decode($server_output);
            if ($response->Messages[0]->Status == 'success') {
                return "true";
            }
        }
    }