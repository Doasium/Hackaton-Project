<?php

class OrderModel
{
    protected $db;

    public function __construct()
    {
        global $db;
        $this->db =  $db;
    }

    public function deleteOrder($orderId)
    {
        // Önce order_items tablosundaki ilişkili satırları silelim
        $this->db->delete('order_items', 'order_id = ?', [$orderId]);

        // Şimdi de orders tablosundan siparişi silelim
        $result = $this->db->delete('orders', 'id = ?', [$orderId])->rowCount();

        if ($result > 0) {
            $response = [
                'success' => true,
                'message' => 'Sipariş başarıyla silindi.'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Sipariş silinirken bir hata oluştu.'
            ];
        }

        return $response;
    }

    public function editGetDetails($id)
    {
        $query = "
            SELECT 
                orders.id,
                orders.order_date,
                orders.customer_id,
                order_items.product_id,
                order_items.quantity
            FROM 
                orders
            JOIN 
                order_items ON orders.id = order_items.order_id
            WHERE 
                orders.id = ?
        ";

        $orderget = $this->db->query($query, [$id]);

        if ($orderget) {
            $result = $orderget->fetchAll();
            if (!empty($result)) {

                return [
                    "success" => true,
                    "data" => $result,
                    "customer_id" => $result[0]["customer_id"]
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Sipariş bulunamadı."
                ];
            }
        } else {
            return [
                "success" => false,
            ];
        }
    }

    public function getAllOrders()
    {
        $query = "
            SELECT o.id AS order_id, u.full_name, u.customer_id, u.sur_name, o.order_date, s.status_name, s.css, 
                SUM(oi.quantity * p.price) AS total_amount
            FROM orders AS o
            LEFT JOIN customer AS u ON o.customer_id = u.customer_id
            LEFT JOIN order_items AS oi ON o.id = oi.order_id
            LEFT JOIN products AS p ON oi.product_id = p.id
            LEFT JOIN order_status AS s ON o.status = s.id
            GROUP BY o.id, u.full_name, u.customer_id, u.sur_name, o.order_date, s.status_name, s.css
        ";

        $result = $this->db->query($query)->fetchAll();

        if ($result) {
            $orders = [];
            foreach ($result as $order) {
                $orders[] = [
                    'order_id' => $order['order_id'],
                    'customer_name' => $order['full_name'] . ' ' . $order['sur_name'],
                    'customer_id' => $order['customer_id'],
                    'order_date' => $order['order_date'],
                    'status' => $order['status_name'],
                    'status_css' => $order['css'],
                    'total_amount' => $order['total_amount']
                ];
            }

            return [
                'success' => true,
                'data' => $orders,
                'message' => 'Başarılı'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Veri bulunamadı.'
            ];
        }
    }

    public function newOrderAdd($data)
    {
        // Transaction başlat
        $this->db->beginTransaction();

        try {
            // Sipariş bilgilerini ekle
            date_default_timezone_set('Europe/Istanbul');
            $orderData = [
                'customer_id' => $data["user_id"],
                'order_date' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('orders', $orderData);

            // Son eklenen siparişin ID'sini al
            $orderId = $this->db->lastInsertId();

            foreach ($data["products"] as $product) {
                $orderProductData = [
                    'order_id' => $orderId,
                    'product_id' => $product["product_id"],
                    'quantity' => $product["quantity"]
                ];
                $this->db->insert('order_items', $orderProductData);
            }

            // Transaction'ı onayla
            $this->db->commit();

            return [
                'success' => true,
                'message' => 'Sipariş başarıyla eklendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            // Hata durumunda transaction'ı geri al
            $this->db->rollBack();
            return [
                'success' => false,
                'message' => 'Sipariş eklenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }
    }

    public function editOrder($orderId, $data)
    {
        // Transaction başlat
        $this->db->beginTransaction();

        try {
            // Sipariş bilgilerini güncelle
            $orderData = [
                'customer_id' => $data["customer"],
                'status' => $data['status'],
            ];

            $this->db->update('orders', $orderData, 'id = ?', [(int)$orderId]);

            $this->db->delete('order_items', 'order_id = ?', [(int)$orderId]);

            // Yeni ürünleri ekle
            if (isset($data["products"]) && is_array($data["products"])) {
                foreach ($data["products"] as $product) {
                    if (isset($product["product_id"]) && isset($product["quantity"])) {
                        $orderProductData = [
                            'order_id' => (int)$orderId,
                            'product_id' => (int)$product["product_id"],
                            'quantity' => (int)$product["quantity"]
                        ];
                        $this->db->insert('order_items', $orderProductData);
                    }
                }
            }

            $this->db->commit();

            return [
                'success' => true,
                'message' => 'Sipariş başarıyla güncellendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            // Hata durumunda transaction'ı geri al
            $this->db->rollBack();
            return [
                'success' => false,
                'message' => 'Sipariş güncellenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red',
                "data" => $data,
                "id" => $orderId
            ];
        }
    }

    public function getStatus()
    {
        global $db;

        $result = $db->select("order_status")->fetchAll();

        if ($result) {
            $response = ["success" => true, "message" => "Başarı ile getirildi", "data" => $result];
        } else {
            $response = ["success" => false, "message" => "Getirilemedi"];
        }
        return $response;
    }
}
