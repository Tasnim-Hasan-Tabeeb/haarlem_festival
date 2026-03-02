<?php

namespace App\Repositories;

use App\Models\Ticket;
use PDO;

class OrderRepository extends Repository
{
    public function getOrders() {
        $stmt = $this->connection->prepare("
            SELECT 
                o.order_id, 
                o.total_amount, 
                o.created_at, 
                o.updated_at,
                oi.item_type, 
                t.customer_name, 
                t.event_name 
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN tickets t ON oi.item_id = t.ticket_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
