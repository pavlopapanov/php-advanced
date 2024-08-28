<?php

return new class implements \Core\Contract\Migration {
    /**
     * Run migration script
     * @return string
     */
    public function up(): string
    {
        return '
        CREATE TABLE notes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            folder_id INT UNSIGNED DEFAULT NULL,
            title VARCHAR(255) NOT NULL,
            content TEXT,
            pinned BOOL DEFAULT false,
            completed BOOLEAN DEFAULT false,
            created_at DATETIME DEFAULT NOW(),
            updated_at DATETIME DEFAULT NOW(),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (folder_id) REFERENCES folders(id) ON DELETE CASCADE
        );
        ';
    }

    /**
     * Rollback migration script
     * @return string
     */
    public function down(): string
    {
        return 'DROP TABLE notes;';
    }
};