<?php

namespace LSP\Repository;

use Orlex\ContainerAwareTrait;

class Talk {
    use ContainerAwareTrait;

    public function fetchAllSelected() {
        /** @var $conn \Aura\Sql\Connection\Mysql */
        $conn = $this->get('sql');

        $talks = $conn->fetchAll(
            'SELECT t.id, t.title, t.description, u.first_name, u.last_name, s.photo_path FROM talks t ' .
            'LEFT JOIN speakers s ON s.user_id=t.user_id ' .
            'LEFT JOIN users u ON u.id=t.user_id ' .
            'WHERE t.selected=1 ' .
            'ORDER BY t.title ASC'
        );

        return $talks;
    }
}