<?php
class Url_model extends CI_Model
{
    public $redbag_url;
    public $pay_url;
    public $user_code;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    public function getInfo($id)
    {
        $this->load->database();
        $query = $this->db->query('SELECT * FROM url_info WHERE id = '.$id);
        return $query->row();
    }

    public function insertInfo()
    {
        $this->load->database();
        $this->redbag_url= $_POST['url1'];
        $this->pay_url = $_POST['url2'];
        
        //
        // 生成这样的SQL代码:
        //   INSERT INTO mytable (title, name, date) VALUES ('{$title}', '{$name}', '{$date}')
        //
        $this->db->insert('url_info', $this);
    }
}
