<?php

namespace App\Models;

use App\Api\Sql;
use Exception;

class CustomerModel
{
    public $db;
    public function __construct()
    {
        $this->db = (new Sql())->getDb();
    }

    public function customers()
    {
        $customerQuery = "SELECT * FROM customer";
        $customers = $this->db->query($customerQuery)->fetchAll();

        if ($customers) {
            // Giriş başarılı
            $response = [
                'success' => true,
                'message' => 'Veri başarılı!',
                'data' => $customers,
                'color' => 'green'
            ];
        } else {
            // Giriş başarısız
            $response = [
                'success' => false,
                'message' => 'Veri başarısız!',
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function sellers_fatura()
    {
        $customerQuery = "SELECT * FROM suppliers";
        $customers = $this->db->query($customerQuery)->fetchAll();

        if ($customers) {
            // Giriş başarılı
            $response = [
                'success' => true,
                'message' => 'Veri başarılı!',
                'data' => $customers,
                'color' => 'green'
            ];
        } else {
            // Giriş başarısız
            $response = [
                'success' => false,
                'message' => 'Veri başarısız!',
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function suppliers()
    {
        $customerQuery = "SELECT * FROM suppliers";
        $customers = $this->db->query($customerQuery)->fetchAll();

        if ($customers) {
            // Giriş başarılı
            $response = [
                'success' => true,
                'message' => 'Veri başarılı!',
                'data' => $customers,
                'color' => 'green'
            ];
        } else {
            // Giriş başarısız
            $response = [
                'success' => false,
                'message' => 'Veri başarısız!',
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function getAuthorities()
    {
        $customerQuery = "SELECT account_id,full_name,email,sur_name,username FROM accounts";
        $yhesap = $this->db->query($customerQuery)->fetchAll();

        if ($yhesap) {
            $response = [
                'success' => true,
                'message' => 'Veri başarılı!',
                'data' => $yhesap,
                'color' => 'green'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Veri başarısız!',
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function delAuthorities($id)
    {
        $response = null;
        $this->db->beginTransaction();
        try {

            $this->db->delete("accounts", "account_id = ?", [$id]);
            $this->db->commit();

            $response = [
                'success' => true,
                'message' => 'Yetkili başarıyla silindi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error inserting customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'Yetkili silinirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }
        return $response;
    }


    public function newCustomer($response)
    {
        $this->db->beginTransaction();

        try {
            $addressData = [
                "district" => $response["district"],
                "country" => "Türkiye",
                "province" => $response["province"],
                "address_detail" => $response["address"]
            ];
            $this->db->insert("addresses", $addressData);

            $lastInsertId = $this->db->lastInsertId();
            if ($lastInsertId === false) {
                throw new Exception('Failed to retrieve last insert ID.');
            }

            $customerData = [
                "company" => $response["company_name"],
                "email" => $response["email"],
                "full_name" => $response["first_name"],
                "sur_name" => $response["sur_name"],
                "address" => $lastInsertId,
                "phone" => $response["phone_number"]
            ];
            $this->db->insert("customer", $customerData);

            $this->db->commit();

            $response = [
                'success' => true,
                'message' => 'Müşteri başarıyla eklendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error inserting customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'Müşteri eklenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function newAuthorities($response)
    {
        $this->db->beginTransaction();

        try {

            $customerData = [
                "username" => $response["user_name"],
                "email" => $response["email"],
                "full_name" => $response["first_name"],
                "sur_name" => $response["sur_name"],
                "password_hash" => md5($response["password"]),
                "permission" => 1,
            ];
            $this->db->insert("accounts", $customerData);

            $this->db->commit();

            $response = [
                'success' => true,
                'message' => 'Yetkili başarıyla eklendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error inserting customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'Yetkili eklenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function deleteCustomer($id)
    {
        try {
            $this->db->beginTransaction();

            // Fetch the address_id associated with the customer
            $stmt = $this->db->query("SELECT address FROM customer WHERE customer_id = ?", [$id]);
            $address = $stmt->fetch();

            if ($address && !is_null($address['address'])) {
                $address_id = $address['address'];

                // Delete the customer record
                $this->db->delete('customer', 'customer_id = ?', [$id]);

                // Delete the address record if address_id is valid
                if ($address_id) {
                    $this->db->delete('addresses', 'address_id = ?', [$address_id]);
                }

                // Commit the transaction
                $this->db->commit();
                $response = ['success' => true];
            } else {
                // If the customer or address is not found, rollback
                $this->db->rollBack();
                $response = ['success' => false, 'message' => 'Customer or address not found'];
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $this->db->rollBack();
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }

        return $response;
    }

    public function getCustomer($id)
    {

        if (isset($id)) {
            $query = "SELECT 
            c.customer_id,
            c.company,
            c.email,
            c.full_name,
            c.sur_name,
            c.phone,
            a.district,
            a.country,
            a.province,
            a.address_detail
        FROM 
            customer c
        LEFT JOIN 
            addresses a ON c.address = a.address_id
        WHERE 
            c.customer_id = ?";
            $dbselector = $this->db->query($query, [$id])->fetch();
            if ($dbselector) {
                $result = [
                    "success" => true,
                    "message" => "Bilgileri getirildi.",
                    "color" => "green",
                    "data" => $dbselector
                ];
            } else {
                $result = [
                    "success" => false,
                    "message" => "Kimlik Boş",
                    "color" => "red"

                ];
            }
        } else {
            $result = [
                "success" => false,
                "message" => "Kimlik alınamadı",
                "color" => "red"
            ];
        }
        return $result;
    }

    public function editCustomer($response)
    {

        $this->db->beginTransaction();

        try {
            // Müşteri ID'sini al
            $customerId = $response["id"];

            // Müşteri bilgilerini güncelle
            $customerData = [
                "company" => $response["company_name"],
                "email" => $response["email"],
                "full_name" => $response["first_name"],
                "sur_name" => $response["sur_name"],
                "phone" => $response["phone_number"]
            ];
            $this->db->update("customer", $customerData, "customer_id = ?", [$customerId]);

            $this->db->select("customer", "address", "customer_id = ?", [$customerId]);
            $addressId = $this->db->fetch()["address"];

            $addressData = [
                "district" => $response["district"],
                "country" => "Türkiye",
                "province" => $response["province"],
                "address_detail" => $response["address"]
            ];
            $this->db->update("addresses", $addressData, "address_id = ?", [$addressId]);

            $this->db->commit();

            $response = [
                'success' => true,
                'message' => 'Müşteri başarıyla güncellendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error updating customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'Müşteri güncellenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }

        return $response;
    }
}
