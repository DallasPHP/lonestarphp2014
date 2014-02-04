<?php

namespace LSP\Repository;

use Orlex\ContainerAwareTrait;

class Speaker {
    use ContainerAwareTrait;

    public function fetchAllSelected() {
        /** @var $conn \Aura\Sql\Connection\Mysql */
        $conn = $this->get('sql');
        $marshal = $this->get('marshal');

        // Get all selected speakers and PHP Foundations Trainers
        $users = $conn->fetchAll(
            'SELECT u.id, u.first_name, u.last_name, u.company, u.twitter, s.bio, s.photo_path FROM talks t ' .
            'LEFT JOIN speakers s ON s.user_id=t.user_id ' .
            'LEFT JOIN users u ON u.id=t.user_id ' .
            'WHERE t.selected=1 OR u.id IN(237,41,341)' .
            'GROUP BY u.id ' .
            'ORDER BY u.first_name ASC'
        );

        $speakerIds = $marshal->users->load($users);

        $talks = $conn->fetchAll(
            'SELECT t.id, t.user_id, t.title, t.description FROM talks t WHERE selected = 1 AND user_id IN (:speakerIds)',
            ['speakerIds' => $speakerIds]
        );

        $marshal->talks->load($talks);

        return $marshal->users;
    }

    public function fetchRandom($limit = 8)
    {
        /** @var $conn \Aura\Sql\Connection\Mysql */
        $conn = $this->get('sql');

        // Get all selected speakers and PHP Foundations Trainers
        $users = $conn->fetchAll(
            'SELECT u.id, u.first_name, u.last_name, s.photo_path FROM talks t ' .
            'LEFT JOIN speakers s ON s.user_id=t.user_id ' .
            'LEFT JOIN users u ON u.id=t.user_id ' .
            'WHERE t.selected=1 OR u.id IN(237,41,341)' .
            'GROUP BY u.id ' .
            'ORDER BY RAND()' .
            'LIMIT ' . $limit
        );

        return $users;
    }
}