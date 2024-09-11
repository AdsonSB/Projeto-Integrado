<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Nota: Adicionei um ponto e vírgula ao final da instrução SQL.
$pdo->exec('CREATE TABLE product (
    id INTEGER PRIMARY KEY, 
    description TEXT, 
    name TEXT,
    category TEXT, 
    price REAL, 
    quantity INTEGER
)');
