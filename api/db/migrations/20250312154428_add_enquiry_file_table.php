<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddEnquiryFileTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $enquiry_files = $this->table('enquiry_files');
        $enquiry_files->addColumn('enquiry_id', 'integer', ['signed' => false])
            ->addColumn('file_name', 'string')
            ->addTimestamps()
            ->addForeignKey('enquiry_id', 'enquiries', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
