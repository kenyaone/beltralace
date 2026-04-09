<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DecodeBase64BodyContent extends AbstractMigration
{
    /**
     * Decode any base64-encoded body content in the pages and widgets tables
     * back to plain HTML/text so that it can be edited from the frontend.
     *
     * This became necessary after the btoa() base64 encoding was removed from
     * the admin forms. Existing rows written before that change have their body
     * stored as a base64 string; this migration decodes them in-place.
     */
    public function up(): void
    {
        $pdo = $this->getAdapter()->getConnection();

        foreach (['pages', 'widgets'] as $table) {
            $rows = $pdo->query("SELECT id, body FROM `{$table}` WHERE body IS NOT NULL AND body != ''")->fetchAll(PDO::FETCH_OBJ);

            $stmt = $pdo->prepare("UPDATE `{$table}` SET body = ? WHERE id = ?");

            foreach ($rows as $row) {
                if ($this->isBase64Encoded($row->body)) {
                    $decoded = base64_decode($row->body, true);
                    if ($decoded !== false) {
                        $stmt->execute([$decoded, $row->id]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
        // Intentionally left empty — re-encoding decoded HTML back to base64
        // would corrupt content and is not a meaningful rollback.
    }

    private function isBase64Encoded(string $string): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)
            && strlen($string) % 4 === 0;
    }
}
