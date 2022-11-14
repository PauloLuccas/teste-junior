<?php

namespace App\Services;

class ValidationService
{
    /**
     * @inheritDoc
     */
    public function verifyCep(string $cep)
    {

        try {
            $isCep = preg_replace('/[^0-9]/', '', $cep);

            if(strlen($isCep) === 8)
                $this->verifyViaCep($isCep);
            else
                throw new \Exception('Invalid Zip Code');

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * @inheritDoc
     */
    public function verifyViaCep(string $cep)
    {

        try {
            $url = 'https://viacep.com.br/ws/'.$cep.'/json/';
            $address = json_decode(file_get_contents($url));

            if(property_exists($address, 'erro'))
                throw new \Exception('Zip Code not found.');
            else
                return $address;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function verifyCpf($cpf) {

        try {
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

            if (strlen($cpf) != 11) {
                throw new \Exception('Invalid CPF!');
            }

            if (preg_match('/(\d)\1{10}/', $cpf)) {
                throw new \Exception('Invalid CPF!');
            }

            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    throw new \Exception('Invalid CPF!');
                }
            }
            return $cpf;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}