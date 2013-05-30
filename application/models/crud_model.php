<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Crud_model extends CI_Model {
     
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
     
    public function create()
    {
        return $this->db->insert('mobil',array(
            'type'=>$this->input->post('type',true),
            'barang'=>$this->input->post('barang',true),
            'harga'=>$this->input->post('harga',true)
        ));
    }
     
    public function update($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('mobil',array(
            'type'=>$this->input->post('type',true),
            'barang'=>$this->input->post('barang',true),
            'harga'=>$this->input->post('harga',true)
        ));
    }
     
    public function delete($id)
    {
        return $this->db->delete('mobil', array('id' => $id)); 
    }
     
    public function getJson()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'userid';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('tbl_fusindo_trx')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('tbl_fusindo_trx');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'userid'=>$data['userid'],
                'sender_name'=>$data['sender_name'],
                'sender_address'=>$data['sender_address'],
                'receiver_name'=>$data['receiver_name'],
                'receiver_address'=>$data['receiver_address'],
                'amount'=>$data['amount']
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($result);
    }
}
 
/* End of file crud_model.php */
/* Location: ./application/controllers/crud_model.php */