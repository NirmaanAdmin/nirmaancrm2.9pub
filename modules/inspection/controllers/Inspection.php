<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inspection extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inspection_model');
    }

    /* List all announcements */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('inspection', 'table'));
        }
        $data['title'] = _l('quality');
        $this->load->view('manage', $data);
    }

    public function create_inspection($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->inspection_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('inspection')));
                    redirect(admin_url('inspection'));
                }
            } else {
                $success = $this->inspection_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('inspection')));
                }
                redirect(admin_url('inspection'));
            }
        }
        if ($id == '') {
            $title = _l('new_inspection', _l('new_inspection'));
        } else {
            $data['inspection'] = $this->inspection_model->get($id);
            $title = _l('edit_inspection', _l('edit_inspection'));
        }

        $data['title'] = $title;
        $data['projects'] = $this->projects_model->get_items();
        $data['inspection_types'] = $this->inspection_model->get_inspection_types();
        $data['vendors'] = $this->inspection_model->get_vendor();
        $data['members'] = $this->inspection_model->get_staffs();

        $this->load->view('inspection', $data);
    }

    /* Delete announcement from database */
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('inspection'));
        }
        $response = $this->inspection_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('inspection')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('inspection')));
        }
        redirect(admin_url('inspection'));
    }
}
