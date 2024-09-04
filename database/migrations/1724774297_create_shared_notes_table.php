<?php
return new class implements \Core\Contract\Migration
{
    /**
    * Run migration script
    * @return string
    */
    public function up(): string 
    {
        return '
        CREATE TABLE shared_notes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            note_id INT UNSIGNED NOT NULL,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (note_id) REFERENCES notes(id) ON DELETE CASCADE
        );
        ';
    }
    
    /**
    * Rollback migration script
    * @return string
    */    
    public function down(): string
    {
        return 'DROP TABLE shared_notes;';
    }
};