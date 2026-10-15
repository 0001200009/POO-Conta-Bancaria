<?php
class ContaBancaria {
    private $numeroConta;
    private $nomeTitular;
    private $cpf;
    private $agencia;
    private $tipoConta;
    private $saldo;
    private $situacao;

    public function __construct($numeroConta, $nomeTitular, $cpf, $agencia, $tipoConta, $saldoInicial = 0.0, $situacaoInicial = "Ativa") {
        $this->numeroConta = $numeroConta;
        $this->nomeTitular = $nomeTitular;
        $this->cpf = $cpf;
        $this->agencia = $agencia;
        $this->tipoConta = $tipoConta;
        $this->saldo = $saldoInicial;
        $this->situacao = $situacaoInicial;
    }

    public function getNumeroConta() { return $this->numeroConta; }
    public function getNomeTitular() { return $this->nomeTitular; }
    public function getCpf() { return $this->cpf; }
    public function getAgencia() { return $this->agencia; }
    public function getTipoConta() { return $this->tipoConta; }
    public function getSaldo() { return $this->saldo; }
    public function getSituacao() { return $this->situacao; }

    public function apresentarDados() {
        echo "==========================================\n";
        echo "Banco Horizonte\n";
        echo "Conta: " . $this->numeroConta . "\n";
        echo "Titular: " . $this->nomeTitular . "\n";
        echo "CPF: " . $this->cpf . "\n";
        echo "Agência: " . $this->agencia . "\n";
        echo "Tipo: " . $this->tipoConta . "\n";
        echo "Saldo: R$ " . number_format($this->saldo, 2, ',', '.') . "\n";
        echo "Situação: " . $this->situacao . "\n";
        echo "==========================================\n";
    }

    public function depositar($valor) {
        if ($this->situacao === "Bloqueada") {
            echo "Erro: Não é permitido realizar depósitos em contas bloqueadas.\n";
            return false;
        }
        if ($valor <= 0) {
            echo "Erro: O valor do depósito deve ser maior que zero.\n";
            return false;
        }

        $this->saldo += $valor;
        echo "Depósito de R$ " . number_format($valor, 2, ',', '.') . " realizado com sucesso!\n";
        return true;
    }

    public function sacar($valor) {
        if ($this->situacao === "Bloqueada") {
            echo "Erro: Não é permitido realizar saques em contas bloqueadas.\n";
            return false;
        }
        if ($valor <= 0) {
            echo "Erro: O valor do saque deve ser maior que zero.\n";
            return false;
        }
        if ($valor > $this->saldo) {
            echo "Erro: Saque recusado. Saldo insuficiente.\n";
            return false;
        }

        $this->saldo -= $valor;
        echo "Saque de R$ " . number_format($valor, 2, ',', '.') . " realizado com sucesso!\n";
        return true;
    }

    public function consultarSaldo() {
        echo "Saldo atual da conta " . $this->numeroConta . " (" . $this->nomeTitular . "): R$ " . number_format($this->saldo, 2, ',', '.') . "\n";
        return $this->saldo;
    }

    public function alterarTitular($novoNome) {
        if (empty(trim($novoNome))) {
            echo "Erro: A alteração não foi realizada. O nome não pode estar vazio.\n";
            return false;
        }
        $this->nomeTitular = trim($novoNome);
        echo "Nome do titular alterado para: " . $this->nomeTitular . "\n";
        return true;
    }

    public function bloquearConta() {
        $this->situacao = "Bloqueada";
        echo "Conta " . $this->numeroConta . " foi BLOQUEADA.\n";
    }

    public function desbloquearConta() {
        $this->situacao = "Ativa";
        echo "Conta " . $this->numeroConta . " foi DESBLOQUEADA.\n";
    }

    public function transferir($valor, ContaBancaria $contaDestino) {
        if ($valor <= 0) {
            echo "Erro: O valor da transferência deve ser maior que zero.\n";
            return false;
        }
        if ($this->situacao !== "Ativa") {
            echo "Erro: A conta de origem está " . $this->situacao . ".\n";
            return false;
        }
        if ($contaDestino->getSituacao() !== "Ativa") {
            echo "Erro: A conta de destino está " . $contaDestino->getSituacao() . ".\n";
            return false;
        }
        if ($valor > $this->saldo) {
            echo "Erro: Transferência recusada. Saldo insuficiente na conta de origem.\n";
            return false;
        }

        $this->saldo -= $valor;
        $contaDestino->saldo += $valor;
        echo "Transferência de R$ " . number_format($valor, 2, ',', '.') . " realizada com sucesso para a conta " . $contaDestino->getNumeroConta() . "!\n";
        return true;
    }

    public function emitirRelatorio() {
        echo "========== RELATÓRIO DA CONTA ==========\n";
        echo "Número da Conta: " . $this->numeroConta . "\n";
        echo "Titular: " . $this->nomeTitular . "\n";
        echo "Agência: " . $this->agencia . "\n";
        echo "Tipo de Conta: " . $this->tipoConta . "\n";
        echo "Saldo Disponível: R$ " . number_format($this->saldo, 2, ',', '.') . "\n";
        echo "Situação Atual: " . $this->situacao . "\n";
        echo "========================================\n\n";
    }
}
?>