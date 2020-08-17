<?php

 class Login extends Model {

    public function validation(){
       $erros = [];

        if(!$this->email){
            $erros['email'] = 'E-mail é um campo obrigatório.';
        }

        if(!$this->password){
            $erros['password'] = 'Por favor, informe a senha.';
        }

        if(count($erros) > 0){
            throw new ValidationException($erros);
            
        }
    }
      
    public function checkLogin(){
        $this->validation();
        $user = User::getOne(['email' => $this->email]);
         if($user){
              if($user->end_date){
                  throw new AppException("Usuário está desligado da empresa.");   
              }
             if(password_verify($this->password, $user->password)) {
                 return $user;
             }
         }

         throw new AppException('Usuário/Senha inválidos.');
         
    }
 }


?>