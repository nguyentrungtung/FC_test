<?php
require_once ("Report.php");

class Store_account_outstanding extends Report
{

    function __construct()
    {
        parent::__construct();
    }

    public function getDataColumns()
    {
        return array(
            array(
                'data' => lang('common_sale_id'),
                'align' => 'left'
            ),
            array(
                'data' => lang('common_customer_name'),
                'align' => 'left'
            ),
            array(
                'data' => lang('common_date'),
                'align' => 'left'
            ),
            array(
                'data' => lang('common_total_charge_to_account'),
                'align' => 'left'
            ),
            array(
                'data' => lang('common_comment'),
                'align' => 'left'
            ),
            array(
                'data' => lang('reports_mark_as_paid') . '/' . lang('reports_mark_as_unpaid'),
                'align' => 'left'
            )
        );
    }

    public function getData()
    {
        $this->db->select('store_accounts.sale_id');
        $this->db->from('store_accounts');
        $this->db->where('transaction_amount >', 0);
        
        if ($this->params['customer_id'] != - 1) {
            $this->db->where('customer_id', $this->params['customer_id']);
        }
        if (! $this->params['show_paid']) {
            $this->db->where('sale_id NOT IN (SELECT sale_id FROM ' . $this->db->dbprefix('store_accounts_paid_sales') . ' WHERE sale_id is NOT NULL)');
        }
        $this->db->order_by('date', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
        
        // If we are exporting NOT exporting to excel make sure to use offset and limit
        if (isset($this->params['export_excel']) && ! $this->params['export_excel']) {
            $this->db->limit($this->report_limit);
            $this->db->offset($this->params['offset']);
        }
        
        $sale_ids = array();
        
        foreach ($this->db->get()->result_array() as $row) {
            $sale_ids[] = $row['sale_id'];
        }
        $this->db->select('CONCAT(customer_person_info.first_name," ",customer_person_info.last_name) as customer_name, customers.account_number, sales.sale_id, sale_time,SUM(payment_amount) as payment_amount,sales.comment', false);
        $this->db->from('sales');
        $this->db->join('sales_payments', 'sales.sale_id = sales_payments.sale_id');
        $this->db->join('people as customer_person_info', 'sales.customer_id = customer_person_info.person_id');
        $this->db->join('customers', 'sales.customer_id = customers.person_id');
        
        if (! empty($sale_ids)) {
            $this->db->where_in('sales.sale_id', $sale_ids);
        } else {
            $this->db->where_in('sales.sale_id', array(
                0
            ));
        }
        
        $store_account_in_all_languages = get_all_language_values_for_key('common_store_account', 'common');
        
        $this->db->where_in('sales_payments.payment_type', $store_account_in_all_languages);
        $this->db->order_by('sale_time', ($this->config->item('report_sort_order')) ? $this->config->item('report_sort_order') : 'asc');
        $this->db->group_by('sale_id');
        $return = $this->db->get()->result_array();
        for ($k = 0; $k < count($return); $k ++) {
            $this->db->from('store_accounts_paid_sales');
            $this->db->where('sale_id', $return[$k]['sale_id']);
            $query = $this->db->get();
            $paid = ($query->num_rows() >= 1);
            
            if ($paid) {
                $return[$k]['paid'] = TRUE;
            } else {
                $return[$k]['paid'] = FALSE;
            }
        }
        
        return $return;
    }

    public function getSummaryData()
    {
        $this->db->select('store_accounts.sale_id');
        $this->db->from('store_accounts');
        $this->db->where('transaction_amount >', 0);
        if ($this->params['customer_id'] != - 1) {
            $this->db->where('customer_id', $this->params['customer_id']);
        }
        
        if (! $this->params['show_paid']) {
            $this->db->where('sale_id NOT IN (SELECT sale_id FROM ' . $this->db->dbprefix('store_accounts_paid_sales') . ' WHERE sale_id is NOT NULL)');
        }
        
        $this->db->order_by('date');
        
        $sale_ids = array();
        
        foreach ($this->db->get()->result_array() as $row) {
            $sale_ids[] = $row['sale_id'];
        }
        
        $this->db->select('SUM(payment_amount) as total', false);
        $this->db->from('sales');
        $this->db->join('sales_payments', 'sales.sale_id = sales_payments.sale_id');
        
        if (! empty($sale_ids)) {
            $this->db->where_in('sales.sale_id', $sale_ids);
        } else {
            $this->db->where_in('sales.sale_id', array(
                0
            ));
        }
        
        $store_account_in_all_languages = get_all_language_values_for_key('common_store_account', 'common');
        
        $this->db->where_in('sales_payments.payment_type', $store_account_in_all_languages);
        return $this->db->get()->row_array();
    }

    function getTotalRows()
    {
        $this->db->select('store_accounts.sale_id');
        $this->db->from('store_accounts');
        $this->db->where('transaction_amount >', 0);
        if ($this->params['customer_id'] != - 1) {
            $this->db->where('customer_id', $this->params['customer_id']);
        }
        
        if (! $this->params['show_paid']) {
            $this->db->where('sale_id NOT IN (SELECT sale_id FROM ' . $this->db->dbprefix('store_accounts_paid_sales') . ' WHERE sale_id is NOT NULL)');
        }
        return $this->db->count_all_results();
    }
}
?>