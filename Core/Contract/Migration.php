<?php

namespace Core\Contract;

interface Migration
{
    public const string TEMPLATE = <<<EOD
    <?php
    return new class implements \Core\Contract\Migration
    {
        /**
        * Run migration script
        * @return string
        */
        public function up(): string 
        {
          return '';
        }
        
        /**
        * Rollback migration script
        * @return string
        */    
        public function down(): string
        {
          return '';
        }
    };
    EOD;

    public function up(): string;

    public function down(): string;
}