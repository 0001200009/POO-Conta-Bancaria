<?php

require_once 'ContaBancaria.php';

echo "=== INICIANDO TESTES DO BANCO HORIZONTE ===\n\n";

$conta1001 = new ContaBancaria("1001", "Ana Souza", "123.456.789-00", "Centro", "Corrente");
$conta1002 = new ContaBancaria("1002", "Carlos Oliveira", "987.654.321-11", "Centro", "Poupança");
$conta1003 = new ContaBancaria("1003", "Mariana Lima", "456.789.123-22", "Jardins", "Corrente");


echo "--- Teste 1: Criar uma conta com saldo inicial igual a zero ---\n";
$conta1001->apresentarDados();

echo "\n--- Teste 2: Depositar R$ 500,00 em uma conta ativa ---\n";
$conta1001->depositar(500.00);

echo "\n--- Teste 3: Sacar R$ 100,00 da mesma conta ---\n";
$conta1001->sacar(100.00);

echo "\n--- Teste 4: Tentar realizar um depósito de R$ 0,00 ---\n";
$conta1001->depositar(0.00);

echo "\n--- Teste 5: Tentar realizar um saque superior ao saldo disponível ---\n";
$conta1001->sacar(1000.00);

echo "\n--- Teste 6: Alterar o nome do titular de uma conta ---\n";
$conta1001->alterarTitular("Ana Souza Silva");

echo "\n--- Teste 7: Bloquear uma conta e tentar realizar um saque ---\n";
$conta1001->bloquearConta();
$conta1001->sacar(50.00);

echo "\n--- Teste 8: Consultar o saldo de uma conta bloqueada ---\n";
$conta1001->consultarSaldo();

echo "\n--- Teste 9: Desbloquear a conta e realizar um depósito ---\n";
$conta1001->desbloquearConta();
$conta1001->depositar(200.00);

echo "\n--- Teste 10: Transferir dinheiro entre duas contas ativas ---\n";
$conta1002->depositar(300.00); 
$conta1001->transferir(200.00, $conta1002);

echo "\n--- Teste 11: Tentar transferir um valor superior ao saldo disponível ---\n";
$conta1001->transferir(5000.00, $conta1002);

echo "\n--- Teste 12: Verificar os saldos das contas após todas as operações ---\n";
$conta1001->consultarSaldo();
$conta1002->consultarSaldo();
$conta1003->consultarSaldo();

echo "\n=== RELATÓRIOS FINAIS ===\n\n";
$conta1001->emitirRelatorio();
$conta1002->emitirRelatorio();
$conta1003->emitirRelatorio();
?>