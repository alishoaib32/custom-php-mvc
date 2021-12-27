<?php

namespace App\Repositories;

use App\Models\Customer\Customer;
use PDO;

class CustomerRepository implements \App\Repositories\Interfaces\CustomerRepositoryInterface
{
    protected $db;
    protected $table;
    protected $modleClass;

    public function __construct(Customer $customer)
    {
        $this->db = $customer::getDB();
        $this->table = $customer->table;

    }

    /**
     * find customer by Id
     * @param customer  id
     * @response customer array | null
     */
    public function find($id)
    {
        try {

            $SQL = "
            SELECT * 
             FROM {$this->table}
             WHERE id = :id
        ";
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
     * find Customers by filters
     * @param $fields ,$filters array
     * @response customers associated array | null
    */
    public function findByFilters($fields, $filters)
    {
        try {
            $sql = "SELECT " . (is_array($fields) && count($fields) > 0 ? implode(",", $fields) : '*') . " FROM {$this->table}  c ";
            if (!empty($filters)) {
                $sql .= " WHERE c.created_at >= :start_date AND c.created_at <= :end_date ";
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
     * find all customer
     * @response customers associated array | null
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
     * Save customer
     * @params customer object
     * @response customer object | null
    */
    public function save(Customer $customer)
    {
        // If the ID is set, we're updating an existing record
        try {
            if (isset($customer->id)) {
                return $this->update($customer);
            }

            $stmt = $this->db->prepare('
            INSERT INTO $this->table 
                (first_name, last_name, email) 
            VALUES 
                (:first_name, :last_name , :email)
        ');

            $stmt->bindParam(':first_name', $customer->first_name);
            $stmt->bindParam(':last_name', $customer->last_name);
            $stmt->bindParam(':email', $customer->email);
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
     * Update customer
     * @params customer object
     * @response customer object | null | exception
   */
    public function update(Customer $customer)
    {
        try {
            if (!isset($customer->id)) {
                // We can't update a record unless it exists...
                throw new \LogicException(
                    'Cannot update order that does not yet exist in the database.'
                );
            }

            $stmt = $this->db->prepare('
            UPDATE $this->table 
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email
            WHERE id = :id
        ');

            $stmt->bindParam(':first_name', $customer->customer_id);
            $stmt->bindParam(':last_name', $customer->total_amount);
            $stmt->bindParam(':email', $customer->country_id);
            $stmt->bindParam(':id', $customer->id);
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