<?php

namespace App\Repositories;

use App\Models\Ticket;
use PDO;

class OrderRepository extends Repository
{
    public function getTicketWithQRCode($qrCode)
    {
        $stmt = $this->connection->prepare("SELECT * FROM tickets WHERE qr_code = :qrCode");
        $stmt->bindParam(':qrCode', $qrCode);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($userId, $totalAmount)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO orders (user_id, total_amount, payment_status) VALUES (:user_id, :total_amount, 'completed')"
        );
        $stmt->execute(['user_id' => $userId, 'total_amount' => $totalAmount]);

        return $this->connection->lastInsertId();
    }

    public function addOrderItem($orderId, $itemType, $itemId)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO order_items (order_id, item_type, item_id) VALUES (:order_id, :item_type, :item_id)"
        );
        $stmt->execute(['order_id' => $orderId, 'item_type' => $itemType, 'item_id' => $itemId]);
    }

    public function createTicket(Ticket $ticket)
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO tickets (customer_name, event_name, event_date, event_time, qr_code, status) VALUES (:customer_name, :event_name, :event_date, :event_time, :qr_code, 'new')"
        );
        $stmt->execute([
            'customer_name' => $ticket->getCustomerName(),
            'event_name' => $ticket->getEventName(),
            'event_date' => $ticket->getEventDate(),
            'event_time' => $ticket->getEventTime(),
            'qr_code' => $ticket->getQrCode(),
        ]);

        return $this->connection->lastInsertId();
    }

    public function getTicketsByOrderId($orderId)
    {
        $stmt = $this->connection->prepare("
            SELECT t.*
            FROM order_items oi
            JOIN tickets t ON oi.item_id = t.ticket_id
            WHERE oi.order_id = :order_id
              AND oi.item_type IN ('history_ticket', 'dance_pass', 'dance_ticket')
        ");
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTicketStatus($qrCode)
    {
        $stmt = $this->connection->prepare(
            "UPDATE tickets SET status = 'used' WHERE qr_code = :qr_code"
        );
        $stmt->execute(['qr_code' => $qrCode]);
        return true;
    }
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
