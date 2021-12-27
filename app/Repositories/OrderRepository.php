<?php

namespace App\Repositories;

use App\Models\Order\Order;
use PDO;

class OrderRepository implements \App\Repositories\Interfaces\OrderRepositoryInterface
{
    protected $db;
    protected $table;
    protected $modleClass;

    public function __construct(Order $order)
    {
        $this->db = $order::getDB();
        $this->table = $order->table;
    }

    /**
     * find Order by Id
     * @param order id
     * @response order array | null
     */
    public function find($id)
    {
        try {
            $SQL = "
            SELECT * 
             FROM {$this->table}
             WHERE id = :id ";

            $stmt = $this->db->prepare($SQL);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {

            global $logger;
            // Output unexpected Exceptions.
            $logger->critical("DB Exception ->", [
                "Error" => $e->getMessage()
            ]);

            if (debug == true) {
                echo "<p>DB Exception -></p>";
                print_r($e->getMessage());
            } else {
                return null;
            }
        }
    }

    /**
     * find Orders by filters
     * @param $fields ,$filters array
     * @response order associated array | null
     */
    public function findByFilters($fields, $filters)
    {
        try {
            $sql = "SELECT " . implode(",", $fields) . " FROM {$this->table}  o ";
            //$sql .= "INNER JOIN order_items oi ON oi.order_id  = o.id";
            $sql .= "INNER JOIN customers c ON c.id  = o.customer_id";
            if (!empty($filters)) {
                $sql .= " WHERE purchase_date >= :start_date AND purchase_date <= :end_date ";
                if (!empty($filters['group_by'])) {
                    $sql .= " GROUP BY {$filters['group_by']}";
                }
                if (!empty($filters['order_by']) && !empty($filters['order'])) {
                    $sql .= " Order BY {$filters['order_by']} {$filters['order']}";
                }
                if (!empty($filters['limit'])) {
                    $sql .= " limit :limit ";
                }

            }
            $stmt = $this->db->prepare($sql);
            if (!empty($filters)) {
                $stmt->bindParam(':start_date', $filters['start_date']);
                $stmt->bindParam(':end_date', $filters['end_date']);
                if (!empty($filters['limit'])) {
                    $stmt->bindParam(':limit', $filters['limit']);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {

            global $logger;
            // Output unexpected Exceptions.
            $logger->critical("DB Exception ->", [
                "Error" => $e->getMessage()
            ]);

            if (debug == true) {
                echo "<p>DB Exception -></p>";
                print_r($e->getMessage());
            } else {
                return null;
            }
        }
    }

    /**
     * find all orders
     * @response orders associated array | null
     */
    public function findAll()
    {

        try {

            $SQL = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($SQL);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {

            global $logger;
            // Output unexpected Exceptions.
            $logger->critical("DB Exception ->", [
                "Error" => $e->getMessage()
            ]);

            if (debug == true) {
                echo "<p>DB Exception -></p>";
                print_r($e->getMessage());
            } else {
                return null;
            }
        }
    }

    /**
     * Save order
     * @params order object
     * @response order object | null
     */
    public function save(Order $order)
    {
        // If the ID is set, we're updating an existing record
        try {

            if (isset($order->id)) {
                return $this->update($order);
            }

            $stmt = $this->db->prepare('
            INSERT INTO $this->table 
                (customer_id, total_amount, country_id, device) 
            VALUES 
                (:customer_id, :total_amount , :country_id, :device)
        ');

            $stmt->bindParam(':customer_id', $order->customer_id);
            $stmt->bindParam(':total_amount', $order->total_amount);
            $stmt->bindParam(':country_id', $order->country_id);
            $stmt->bindParam(':device', $order->device);
            return $stmt->execute();

        } catch (\PDOException $e) {

            global $logger;
            // Output unexpected Exceptions.
            $logger->critical("DB Exception ->", [
                "Error" => $e->getMessage()
            ]);

            if (debug == true) {
                echo "<p>DB Exception -></p>";
                print_r($e->getMessage());
            } else {
                return null;
            }
        }

    }

    /**
     * Update order
     * @params order object
     * @response order object | null | exception
     */
    public function update(Order $order)
    {
        try {
            if (!isset($order->id)) {
                // We can't update a record unless it exists...
                throw new \LogicException(
                    'Cannot update order that does not yet exist in the database.'
                );
            }
            $stmt = $this->db->prepare('
            UPDATE $this->table 
            SET customer_id = :customer_id,
                total_amount = :total_amount,
                country_id = :country_id,
                device = :device
            WHERE id = :id
        ');
            $stmt->bindParam(':customer_id', $order->customer_id);
            $stmt->bindParam(':total_amount', $order->total_amount);
            $stmt->bindParam(':country_id', $order->country_id);
            $stmt->bindParam(':device', $order->device);
            $stmt->bindParam(':id', $order->id);
            return $stmt->execute();

        } catch (\PDOException $e) {

            global $logger;
            // Output unexpected Exceptions.
            $logger->critical("DB Exception ->", [
                "Error" => $e->getMessage()
            ]);

            if (debug == true) {
                echo "<p>DB Exception -></p>";
                print_r($e->getMessage());
            } else {
                return null;
            }
        }
    }

}