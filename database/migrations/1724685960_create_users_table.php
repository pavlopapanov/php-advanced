<?php

return new class implements \Core\Contract\Migration
{
    public function up(): string
    {
        return 'CREATE TABLE users (
            id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            password TEXT NOT NULL,
            token TEXT,
            token_expired_at DATETIME,
            created_at DATETIME DEFAULT NOW()
        )';
    }

    public function down(): string
    {
        return 'DROP TABLE users';
    }
};