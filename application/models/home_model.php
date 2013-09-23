<?php
Class Home_Model extends Model {

    function __construct() {
        parent::Model();
    }
    
    function GetDashboardVisits() {
        $q = $this->db->query("
            SELECT 
                COUNT(*) as `jml`
            FROM 
                visits 
            WHERE 
                DATE(`date`) = CURDATE()
        ");
        $data['today'] = $q->row_array();
        
        $q = $this->db->query("
            SELECT 
                COUNT(*) as `jml`
            FROM 
                visits 
            WHERE 
                DATE(`date`) =  DATE_ADD(CURDATE(), INTERVAL -1 DAY)
        ");
        $data['yesterday'] = $q->row_array();
        
        $q = $this->db->query("
            SELECT 
                COUNT(*) as `jml`
            FROM 
                visits 
            WHERE 
                YEARWEEK(`date`) = YEARWEEK(CURDATE())
        ");
        $data['thisweek'] = $q->row_array();
        
        $q = $this->db->query("
            SELECT 
                COUNT(*) as `jml`
            FROM 
                visits 
            WHERE 
                EXTRACT(YEAR_MONTH FROM `date`) = EXTRACT(YEAR_MONTH FROM CURDATE())
        ");
        $data['thismonth'] = $q->row_array();
        
        $q = $this->db->query("
            SELECT 
                COUNT(*) as `jml`
            FROM 
                visits 
            WHERE 
                YEAR(`date`) = YEAR(CURDATE())
        ");
        $data['thisyear'] = $q->row_array();
        
        $q = $this->db->query("
            SELECT 
                ROUND(COUNT(*)/(DAY(LAST_DAY(DATE_ADD(CURDATE(), INTERVAL -1 MONTH)))-(WEEKOFYEAR(LAST_DAY(DATE_ADD(CURDATE(), INTERVAL -1 MONTH))) - WEEKOFYEAR(DATE_ADD(STR_TO_DATE(CONCAT(DATE_FORMAT(CURDATE(), '%Y-%m'), '-01'), '%Y-%m-%d'), INTERVAL -1 MONTH))))) as `jml`
            FROM 
                visits 
            WHERE 
                EXTRACT(YEAR_MONTH FROM `date`) = EXTRACT(YEAR_MONTH FROM DATE_ADD(CURDATE(), INTERVAL -1 MONTH))
        ");
        $data['average'] = $q->row_array();
        return $data;
    }
    	
	function GetDashboardVisitChart() {
		$sql_new = $this->db->query("
			SELECT 
				DATE_FORMAT(v.`date`, '%d/%b') as `name`,
				COUNT(v.`id`) as `count`
			FROM 
				visits v
				JOIN `patients` p ON (p.family_folder = v.family_folder)
			WHERE 
                DATE(v.`date`) BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 DAY) AND CURDATE()
			GROUP BY 
                DATE(v.`date`)
		");
		//echo "<prev>" .$this->db->last_query(). "</prev>";
		$data = $sql_new->result_array();
		return $data;
	}
	
    function GetChat() {
        $display = $this->db->query("
            SELECT COUNT(*) as total FROM chats
        ");
        $data_display = $display->row_array();
        $start = $data_display['total']-30;
        if($start < 0) $start = 0;
        $end = $data_display['total'];
        $sql = $this->db->query("
            SELECT 
                c.id,
                u.id as user_id,
                u.`username` as `username`,
                c.msg as msg,
                DATE_FORMAT(c.date,'%Y-%m-%d') as tanggal,
				CURDATE() as sekarang
            FROM 
                chats c
                JOIN users u ON (u.id = c.user_id)
            WHERE DATE_FORMAT(c.date,'%Y-%m-%d') = CURDATE()
            ORDER BY c.id
        ");
      // echo "<prev>" .$this->db->last_query(). "</prev>";
        return $sql->result_array();
    }
    
    function DoAddChat() {
		if($this->input->post('chat_msg')!="0")	{
			return $this->db->query("
				INSERT INTO chats(user_id, msg)
				VALUES(?, ?)
			",
			array(
				$this->session->userdata('id'),
				$this->input->post('chat_msg')
			));
		}
    }
    
    function GetAlergi($patientId) {
		$sql = $this->db->query("SELECT id, alergi FROM alergi WHERE family_folder=? ORDER BY id", array($patientId));
		return $sql->result_array();
	}
	
	function DoDeleteAlergi($alergiId) {
		return $this->db->query("DELETE FROM alergi WHERE id=?", array($alergiId));
	}
    
    function DoAddAlergi() {
		if($this->input->post('alergi_msg')!="0")	{
			return $this->db->query("
				INSERT INTO alergi(family_folder, alergi)
				VALUES(?, ?)
			",
			array(
				$this->input->post('alergi_family_folder'),
				$this->input->post('alergi_family_relationship_id'),
				$this->input->post('alergi_msg')
			));
		}
    }
    
}
?>
