<?php

namespace App\Models;

use App\Api\Sql;

class LeassonModel
{

    public $db;

    public function __construct()
    {
        $this->db = (new Sql())->getDb();
    }

    public function getAllLeassons()
    {
        $query = "SELECT st.st_id, st.st_name, st.st_image,st.st_u_id, st.st_description, st.st_video, lc.name,lc.image
        FROM lessons AS st
        LEFT JOIN lessons_categories AS lc ON st.st_id = lc.s_id";
        $result = $this->db->query($query)->fetchAll();
        return $result;
    }

    public function unixId()
    {
        $unix_id = md5(uniqid(mt_rand(), true));
        return $unix_id;
    }

    public function getLeassons($id)
    {
        $query = "SELECT st.st_id, st.st_name, st.st_image,st.st_u_id, st.st_description, st.st_video, lc.name,lc.image
        FROM lessons AS st
        LEFT JOIN lessons_categories AS lc ON st.st_id = lc.s_id WHERE st.st_u_id = ?";
        $result = $this->db->query($query, [$id])->fetch();

        if ($result > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllQuestsCategories()
    {
        $query = "SELECT q.q_quest,q.q_language,l.name,l.image,l.s_id,q.lc_id,q.q_id,q.q_u_id
        FROM question AS q LEFT JOIN lessons_categories AS l ON l.s_id = q.lc_id";
        $result = $this->db->query($query)->fetchAll();
        if ($result > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function getQuest($quest_id)
    {
        $query = "SELECT q.q_quest,q.q_language,l.name,l.image,l.s_id,q.lc_id,q.q_id,q.q_u_id
        FROM question AS q LEFT JOIN lessons_categories AS l ON l.s_id = q.lc_id
        WHERE q.q_u_id = ?";
        $result = $this->db->query($query, [$quest_id])->fetch();
        if ($result > 0) {
            return $result;
        } else {
            return false;
        }
    }
}
