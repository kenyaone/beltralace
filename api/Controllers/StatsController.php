<?php

namespace App\Controllers;

use PDO;
use App\Core\Database;

class StatsController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getDashboard(): array
    {
        $stats = [];

        $q = $this->db->query("SELECT COUNT(*) FROM enquiries");
        $stats['total_enquiries'] = (int) $q->fetchColumn();

        $q = $this->db->query("SELECT COUNT(*) FROM pages WHERE published = 1");
        $stats['published_pages'] = (int) $q->fetchColumn();

        $q = $this->db->query("SELECT COUNT(*) FROM blog_articles");
        $stats['total_blog_articles'] = (int) $q->fetchColumn();

        $q = $this->db->query("SELECT COUNT(*) FROM widgets WHERE published = 1");
        $stats['published_widgets'] = (int) $q->fetchColumn();

        $q = $this->db->query(
            "SELECT DATE_FORMAT(created_at, '%b %Y') AS month,
                    DATE_FORMAT(created_at, '%Y-%m') AS sort_key,
                    COUNT(*) AS count
             FROM enquiries
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
             GROUP BY month, sort_key
             ORDER BY sort_key ASC"
        );
        $stats['monthly_enquiries'] = $q->fetchAll(PDO::FETCH_OBJ);

        $q = $this->db->query(
            "SELECT COALESCE(NULLIF(TRIM(CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,''))), ''), name) AS display_name,
                    email, language, subject,
                    DATE_FORMAT(created_at, '%b %e, %Y') AS created_at
             FROM enquiries
             ORDER BY id DESC
             LIMIT 5"
        );
        $stats['recent_enquiries'] = $q->fetchAll(PDO::FETCH_OBJ);

        return $stats;
    }
}
