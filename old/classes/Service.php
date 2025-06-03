<?php
class Service {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function create($title, $desc, $img) {
        $stmt = $this->pdo->prepare("INSERT INTO services (title, description, image) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $desc, $img]);
    }
    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM services ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($id, $title, $desc, $img) {
        $stmt = $this->pdo->prepare("UPDATE services SET title = ?, description = ?, image = ? WHERE id = ?");
        return $stmt->execute([$title, $desc, $img, $id]);
    }
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function search($term = '') {
        if ($term) {
            $stmt = $this->pdo->prepare('SELECT * FROM services WHERE title LIKE ? OR description LIKE ?');
            $wildcard = "%$term%";
            $stmt->execute([$wildcard, $wildcard]);
        } else {
            $stmt = $this->pdo->query('SELECT * FROM services');
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
