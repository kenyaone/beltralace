<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddEnquiryFields extends AbstractMigration
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
        $table = $this->table('enquiries');
        $table->addColumn('phone', 'string', ['limit' => 255, 'after' => 'name'])
            ->addColumn('email', 'string', ['limit' => 255, 'after' => 'phone'])
            ->addColumn('address', 'string', ['limit' => 255, 'after' => 'email'])
            ->addColumn('town', 'string', ['limit' => 255, 'after' => 'address'])
            ->addColumn('country', 'string', ['limit' => 255, 'after' => 'town'])
            ->addColumn('nationality', 'string', ['limit' => 255, 'after' => 'country'])
            ->addColumn('native_language', 'string', ['limit' => 255, 'after' => 'nationality'])
            ->update();
    }
}
