<?php
namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\GeneralModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Core\Helpers;

class AdminController
{

    public function __construct()
    {
    }

    public function newAuthorized()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }


        Helpers::view(
            "admin/new_authorized",
            ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]
        );
    }

    public function listOrders()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }


        Helpers::view(
            "admin/orders",
            ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]
        );
    }


    public function listSellerInvoices()
    {

        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }


        Helpers::view("admin/suppliers_sales", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }


    public function listProducts()
    {

        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }


        Helpers::view("admin/products", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }

    public function home()
    {
        $userController = new UserController();
        $userModel = new UserModel(300);

        $count = $userModel->usersCount();
        $customer_count = $userModel->customerCount();
        $orders_count = $userModel->ordersCount();
        $totalKazanc = $userModel->totalKazanc();

        Helpers::view("admin/index", [
            "name" => $userController->getUserFullName() . " " . $userController->getUserSurName(),
            "user_count" => $count,
            "customer_count" => $customer_count,
            "orders_count" => $orders_count,
            "total_kazanc" => $totalKazanc
        ]);
    }

    public function listCustomers()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }

        $productModel = new CustomerModel();
        $result = $productModel->customers();

        $html = "";
        foreach ($result["data"] as $customer) {
            $email = !empty($customer["email"]) ? $customer["email"] : 'Yok';
            $html .= "<tr data-id=\"" . $customer["customer_id"] . "\">";
            $html .= "<td>" . $customer["full_name"] . "</td>";
            $html .= "<td>" . $customer["sur_name"] . "</td>";
            $html .= "<td>" . $customer["company"] . "</td>";
            $html .= "<td>" . $customer["phone"] . "</td>";
            $html .= "<td>" . $email . "</td>";
            $html .= '<td>
                <a href="/admin/musteri/' . $customer["customer_id"] . '" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>
                <a href="javascript:void(0)" class="delete-button w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-id="' . $customer["customer_id"] . '">
                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </a>
            </td>';
            $html .= "</tr>";
        }
        Helpers::view("admin/customers", ["customers" => $html, "name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }


    public function viewOrderDetails()
    {
    }

    public function listSuppliers()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }

        Helpers::view("admin/suppliers", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }


    public function listAuthorizedAccounts()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }


        Helpers::view("admin/authorities", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }

    public function newOrder()
    {

        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }
        Helpers::view("admin/new_order", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }

    public function newProduct()
    {

        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }
        Helpers::view("admin/new_product", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }


    public function newCustomer()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }
        Helpers::view("admin/new_customer", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }

    public function viewInvoice($id)
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }
        $productModel = new ProductModel();
        $allProduct = $productModel->getProducts();
        $data = $productModel->getOrderById($id);

        $itemsHtml = "";
        $itemsnokargo = "";
        $orderDate = "";
        $invoiceNumber = ""; // Fatura numarası için bir değişken ekliyoruz

        // Müşteri bilgilerini almak için gerekli sorguları yazıyoruz
        $customerName = "";
        $customerCompany = "";
        $customerAddress = "";
        $phoneCustomer = "";

        $totalShippingPrice = 0;
        $totalProductPrice = 0;
        if ($data['success']) {
            foreach ($data['data'] as $orderItem) {
                $productDetails = null;
                foreach ($allProduct['data'] as $product) {
                    if ($product['id'] == $orderItem['product_id']) {
                        $totalProductPrice += $product["price"] * $orderItem["quantity"];
                        $totalShippingPrice += $product["shipping_cost"] * $orderItem["quantity"];
                        $productDetails = $product;
                        break;
                    }
                }

                if ($productDetails) {
                    $itemsHtml .= "<tr>
                    <td id='productName'>{$productDetails['product_name']}</td>
                    <td id='productNumber'>{$productDetails['id']}</td>
                    <td id='amount'>{$orderItem['quantity']}</td>
                    <td id='price'>{$productDetails['price']} TL</td>
                    <td id='totalPrice'>" . ($orderItem['quantity'] * $productDetails['price']) . " TL</td>
                </tr>";
                } else {
                    $itemsHtml .= "<tr>
                    <td colspan='5'>Ürün bilgisi bulunamadı.</td>
                </tr>";
                }
                if ($productDetails) {
                    $itemsnokargo .= "<tr>
                    <td id='productName'>{$productDetails['product_name']}</td>
                    <td id='productNumber'>{$productDetails['id']}</td>
                    <td id='amount'>{$orderItem['quantity']}</td>
                </tr>";
                } else {
                    $itemsnokargo .= "<tr>
                    <td colspan='5'>Ürün bilgisi bulunamadı.</td>
                </tr>";
                }
            }

            // Order date ve invoice number (fatura numarası) alıyoruz
            if (isset($data['data'][0]['order_date'])) {
                $orderDate = $data['data'][0]['order_date'];
            }
            // Sipariş ID'sini fatura numarası olarak kullanabiliriz
            $invoiceNumber = $id;

            // Müşteri bilgilerini alıyoruz
            $customerModel = new UserModel();
            $customer_id = $productModel->getCustomerIDByOrderID($id); // Müşteri ID'sini al
            $customerData = $customerModel->getCustomerDetails($customer_id);
            if ($customerData['success']) {
                $customerName = $customerData['data']['full_name'] . " " . $customerData['data']['sur_name'];
                $customerCompany = $customerData['data']['company'];
                $customerAddress = $customerData['data']['address_detail'];
                $phoneCustomer = $customerData['data']['phone'];
            }
        } else {
            $itemsHtml = "<tr><td colspan='5'>Sipariş bulunamadı.</td></tr>";
        }

        Helpers::view("admin/invoice", [
            "items" => $itemsHtml,
            "itemsnokargo" => $itemsnokargo,
            "totalprice" => $totalProductPrice,
            "shipping_price" => $totalShippingPrice,
            "create_date" => $orderDate,
            "invoice_number" => $invoiceNumber,
            "order_id" => $id,
            "customer_name" => $customerName,
            "customer_company" => $customerCompany,
            "customer_address" => $customerAddress,
            "customer_phone" => $phoneCustomer,
            "name" => $userController->getUserFullName() . " " . $userController->getUserSurName()
        ]);
    }

    public function newSupplier()
    {
        $userController = new UserController();

        if (!$userController->getLogged()) {
            header("Location: /login");
            exit;
        }
        Helpers::view("admin/new_supplier", ["name" => $userController->getUserFullName() . " " . $userController->getUserSurName()]);
    }
}
