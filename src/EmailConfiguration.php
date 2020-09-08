<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailConfiguration {
    private $mail;

    private $nome;
    private $email;
    private $mensagem;

    private $HOST;
    private $PORTA;
    private $EMAILLM;
    private $SENHA;

    public function __construct(string $nome, string $email, string $mensagem) {
        $this->validaNome($nome);
        $this->nome = $nome;

        $this->validaEmail($email);
        $this->email = $email;
        
        $this->validaMensagem($mensagem);
        $this->mensagem = $mensagem;

        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->HOST = $_ENV['HOST'];
        $this->PORTA =$_ENV['PORTA'];
        $this->EMAILLM = $_ENV['EMAILLM'];
        $this->SENHA = $_ENV['SENHA'];
    }

    public function sendEmail() {
        try {
            $this->mail = new PHPMailer(true);
            $this->mail->CharSet = "UTF-8";
            $this->mail->isSMTP();  
            $this->mail->SMTPAuth = true;                                      
            $this->mail->Host = $this->HOST;
            $this->mail->Port = $this->PORTA;               
            $this->mail->Username = $this->EMAILLM;                    
            $this->mail->Password = $this->SENHA;                             
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
            $this->mail->setFrom($this->email, $this->nome);
            $this->mail->addAddress($this->EMAILLM, 'Leve-Mineral');
        
            $this->mail->isHTML(true);                               
            $this->mail->Subject = 'Leve-Mineral - ' . $this->nome;
            $this->mail->Body    = "Nome: " . $this->nome . "<br>Email: " . $this->email . "<br>Mensagem: " . $this->mensagem;
        
            if ($this->mail->send()) {
                echo "Mensagem enviada com sucesso!";
                return;
            }
        }
        
        catch (Exception $e) {
            echo "Falha no envio da mensagem";
            return;
        }
    }

    public function validaNome(string $nome) {
        if (empty($nome)) {
            echo 'Nome inválido.';
            exit();
        }

        if (strlen($nome) >= 25) {
            echo 'Nome muito grande.';
            exit();
        }

        if (!preg_match('|^[\pL\s]+$|u', $nome)) {
            echo 'Teste';
            exit();
        }
    }

    public function validaEmail($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Email inválido.';
            exit();
        }
    }

    public function validaMensagem($mensagem) {
        if (strlen($mensagem) <= 20) {
            echo 'A mensagem deve conter no minimo 20 caracteres.';
            exit();
        }
    }
}
?>