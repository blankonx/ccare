<?php
Class Receipt_Model extends Model {

    function Receipt_Model() {
        parent::Model();
    }

	function DoAddReceipt() {
        $this->db->query("
            INSERT INTO
				`receipts`(`date`)
			VALUES ( NOW() )"
		);
        return $this->db->insert_id();
	}

}
?>