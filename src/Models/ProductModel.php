<?php

namespace App\Models;

use App\Api\Cache\Cache;
use App\Api\Sql;

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Sql())->getDb();
    }

    public function getPopulerProducts($limit = 6)
    {
        $cache = new Cache('product');
        $cache_key = "popular_products";
        // $cache->clear();
        $time = 1500;

        if ($cache->has($cache_key)) {
            $userData = $cache->get($cache_key);
            if (!$userData) {
                return false;
            }

            $response = [
                "success" => true,
                "cache" => true,
                "data" => $userData
            ];
        } else {
            $limitClause = $limit ? "LIMIT " . (int) $limit : "";

            $query = "
            SELECT p.*, pc.pc_name 
            FROM products p
            JOIN product_categories pc ON p.pc_id = pc.pc_id
            $limitClause
        ";

            $result = $this->db->query($query)->fetchAll();

            if ($result) {
                $cache->set($cache_key, $result, $time);

                $response = [
                    "success" => true,
                    "cache" => false,
                    "data" => $result
                ];
            } else {
                return ["success" => false];
            }
        }

        return $response;
    }

    public function getProducts($page = 1, $limit = 4, $search = '', $categories = [])
    {
        $cache = new Cache('product');
        $cache_key = "products_page_{$page}_limit_{$limit}_search_" . md5($search) . "_category_" . md5(implode(',', $categories));
        $time = 1500;
        // $cache->clear();
        $offset = ($page - 1) * $limit;

        if ($cache->has($cache_key)) {
            $cachedData = $cache->get($cache_key);
            return [
                "success" => true,
                "cache" => true,
                "data" => $cachedData
            ];
        } else {
            // Koşulları tanımla
            $conditions = [];

            if (!empty($search)) {
                $search = $this->db->quote("%$search%");
                $conditions[] = "(p.product_name LIKE $search OR pc.pc_name LIKE $search)";
            }

            if (!empty($categories)) {
                // Kategorileri veritabanı için al
                $categories = array_map(function ($category) {
                    return $this->db->quote($category);
                }, $categories);
                $conditions[] = "pc.pc_name IN (" . implode(',', $categories) . ")";
            }

            // WHERE ifadesini oluştur
            $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

            // Nihai sorgu
            $query = "
            SELECT p.*, pc.pc_name 
            FROM products p
            JOIN product_categories pc ON p.pc_id = pc.pc_id
            $whereClause
            LIMIT $limit OFFSET $offset
            ";

            $result = $this->db->query($query)->fetchAll();

            if ($result) {
                $cache->set($cache_key, $result, $time);
                return [
                    "success" => true,
                    "cache" => false,
                    "data" => $result
                ];
            } else {
                return ["success" => false, "data" => []];
            }
        }
    }

    public function getProductsCount($search = '', $categories = [])
    {
        $cache = new Cache('product');
        $cache_key = "products_page_count_search_" . md5($search) . "_category_" . md5(is_array($categories) ? implode(',', $categories) : '');
        $time = 1500;

        if ($cache->has($cache_key)) {
            $cachedData = $cache->get($cache_key);
            return [
                "success" => true,
                "cache" => true,
                "data" => $cachedData
            ];
        } else {
            // Koşulları tanımla
            $conditions = [];

            if (!empty($search)) {
                $search = $this->db->quote("%$search%");
                $conditions[] = "(p.product_name LIKE $search OR pc.pc_name LIKE $search)";
            }

            if (!empty($categories) && is_array($categories)) { // Burada kontrol ekledik
                // Kategorileri veritabanı için al
                $categories = array_map(function ($category) {
                    return $this->db->quote($category);
                }, $categories);
                $conditions[] = "pc.pc_name IN (" . implode(',', $categories) . ")";
            }

            // WHERE ifadesini oluştur
            $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

            // Nihai sorgu
            $query = "
            SELECT COUNT(*) as total
            FROM products p
            JOIN product_categories pc ON p.pc_id = pc.pc_id
            $whereClause
            ";

            $result = $this->db->query($query)->fetch();

            if ($result) {
                $totalCount = $result['total'];
                $cache->set($cache_key, $totalCount, $time);
                return [
                    "success" => true,
                    "cache" => false,
                    "data" => $totalCount
                ];
            } else {
                return ["success" => false, "data" => 0];
            }
        }
    }



    public function getCategories()
    {
        $query = "
            SELECT * FROM product_categories
            ORDER BY pc_name ASC"; // Kategorileri alfabetik sıraya göre getir

        $result = $this->db->query($query)->fetchAll();

        if ($result) {
            return [
                "success" => true,
                "data" => $result
            ];
        } else {
            return [
                "success" => false,
                "data" => []
            ];
        }
    }
    public function getProductsByIds($ids) {}
}
