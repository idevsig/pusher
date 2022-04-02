<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Channel;

use Pusher\Message;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer extends \Pusher\Channel
{
    public PHPMailer $mail;

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
        $this->mail = new PHPMailer();
        $this->mail->isSMTP(); // Send using SMTP
        $this->setCharSet();
    }

    // Enable verbose debug output
    public function setSMTPDebug(bool $debug): self
    {
        $this->mail->SMTPDebug = $debug ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
        return $this;
    }

    // Enable SMTP authentication
    public function setSMTPAuth(bool $auth): self
    {
        $this->mail->SMTPAuth = $auth;    
        return $this;                               
    }

    // The character set of the message
    public function setCharSet(string $charset = PHPMailer::CHARSET_UTF8): self
    {
        $this->mail->CharSet = $charset;
        return $this;
    }

    // Set the SMTP server and port to send through
    public function setSMTPHostPort(string $host, int $port): self
    {
        $this->mail->Host = $host;
        $this->mail->Port = $port;                    
        return $this;
    }

    // Set the SMTP server to send through
    public function setSMTPHost(string $host): self
    {
        $this->mail->Host = $host;
        return $this;
    }

    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    public function setSMTPPort(int $port = 465): self
    {
        $this->mail->Port = $port;                    
        return $this;               
    }

    // SMTP username, password
    public function setSMTPUser(string $username, string $password): self
    {
        $this->mail->Username = $username;
        $this->mail->Password = $password;         
        return $this;
    }      

    // SMTP username
    public function setSMTPUsername(string $username): self
    {
        $this->mail->Username = $username;
        return $this;
    }    

    // SMTP password
    public function setSMTPPassword(string $password): self
    {
        $this->mail->Password = $password;         
        return $this;
    }    

    // Enable implicit TLS encryption: ssl, tls
    public function setSMTPSecure(string $secure = PHPMailer::ENCRYPTION_SMTPS): self
    {
        $this->mail->SMTPSecure = $secure;
        return $this;
    }

    public function setFrom(string $address, string $name = '', bool $auto = true): self
    {
        $this->mail->setFrom($address, $name, $auto);
        return $this;
    }

    // Add a recipient
    public function addAddress(string $address, string $name = ''): self
    {
        $this->mail->addAddress($address, $name);
        return $this;
    }

    public function addReplyTo(string $address, string $name = ''): self
    {
        $this->mail->addReplyTo($address, $name);
        return $this;
    }

    public function addCC(string $address, string $name = ''): self
    {
        $this->mail->addCC($address, $name);
        return $this;
    }

    public function addBCC(string $address, string $name = ''): self
    {
        $this->mail->addBCC($address, $name);
        return $this;
    }

    public function isHTML(bool $html = true): self
    {
        $this->mail->isHTML($html);
        return $this;
    }

    public function getStatus(): bool
    {
        $this->showResp();
        return $this->status;
    }
    
    public function send(Message $message): bool
    {
        $postData = $message->getParams();
        $this->mail->Subject = $postData['subject'];
        $this->mail->Body    = $postData['body'];
        $this->mail->AltBody = $postData['altBody'];
        // var_dump($this->mail);

        $this->status = $this->mail->send();
        return $this->status;
    }

    public function requestContent(Message $message): string
    {
        $this->content = $this->send($message) ? 'success' : $this->mail->ErrorInfo;
        return $this->content;
    }

    public function requestArray(Message $message): array
    {
        $resp = [];
        $this->requestContent($message);
        if ($this->status) {
            $resp = [
                'code' => 0,
                'message' => 'success',
            ];
        } else {
            $resp = [
                'code' => 1,
                'message' => $this->mail->ErrorInfo,
            ];
        }
        return $resp;
    }
}
