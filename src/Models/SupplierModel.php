<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/api/sql.php");



class SupplierModel
{

    public function delSuppliers($id)
    {
        global $db;
        $response = null;
        $db->beginTransaction();
        try {

            $db->delete("suppliers", "supplier_id = ?", [$id]);
            $db->commit();

            $response = [
                'success' => true,
                'message' => 'başarıyla silindi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $db->rollBack();
            error_log('Error inserting customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'silinirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }
        return $response;
    }

    public function getSuppliers()
    {
        global $db;

        $customerQuery = "SELECT * FROM suppliers";
        $yhesap = $db->query($customerQuery)->fetchAll();

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



    public function newSupplier($data)
    {
        global $db;
        $db->beginTransaction();

        try {
            $dataSupplier = [
                "company" => $data["company_name"],
                "full_name" => $data["first_name"],
                "sur_name" => $data["sur_name"],
                "email" => $data["email"],
                "phone" => $data["phone_number"],
            ];

            $db->insert("suppliers", $dataSupplier);


            $db->commit();

            $response = [
                'success' => true,
                'message' => 'Müşteri başarıyla eklendi.',
                'color' => 'green'
            ];
        } catch (Exception $e) {
            $db->rollBack();
            error_log('Error inserting customer: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'Müşteri eklenirken hata oluştu: ' . $e->getMessage(),
                'color' => 'red'
            ];
        }

        return $response;
    }

    public function getTotalSales()
    {
        global $db;

        $data = $db->select("suppliers", "*")->fetchAll();

        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Veri getirildi.',
                'data' => $data,
                'color' => 'green'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Veri getirilemedi.',
                'color' => 'red'
            ];
        }
        return $response;
    }

    public function editPriceSupplier($data)
    {
        global $db;

        $id = $data["id"];
        if (isset($id)) {

            $get = $db->select("suppliers", "*", "supplier_id = ?", [$id])->fetch();
            if ($get) {

                $price  = (int)$get["repayment"] + (int)$data["be_paid"] - (int) $data["paid"];

                $update = $db->update("suppliers", ["repayment" =>  $price], "supplier_id = ?", [$id]);
                if ($update) {
                    $response = [
                        'success' => true,
                        'message' => 'Veri Düzeltildi.',
                        'color' => 'green',
                        "payment" => $price
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Veri güncellenemedi.',
                        'color' => 'red'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Böyle bir veri yok.',
                    'color' => 'red'
                ];
            }
        } else {
            $response = [
                'success' => true,
                'message' => 'İd yanlış.',
                'color' => 'red'
            ];
        }
        return $response;
    }

    public function getPersonSupplier($id){
        global $db;

        $data = $db->select("suppliers","*","supplier_id = ?", [(int)$id])->fetch();
        if ($data) {
            $response = [
                'success' => true,
                'message' => 'Veri getirildi.',
                'data' => $data,
                'color' => 'green'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Veri getirilemedi.',
                'color' => 'red'
            ];
        }
        return $response;
    }

    public function editPersonSupplier($data){
        global $db;

        $updateData = [
            "company" => $data["company"],
            "full_name" => $data["full_name"],
            "sur_name" => $data["sur_name"],
            "phone" => $data["phone"],
            "email" => $data["email"],
        ];


        $update = $db->update("suppliers",$updateData,"supplier_id = ?",[(int)$data["id"]]);

        if ($update) {
            $response = [
                'success' => true,
                'message' => 'Veri güncellendi.',
                'color' => 'green'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Veri getirilemedi.',
                'color' => 'red'
            ];
        }
        return $response;

    }
}
