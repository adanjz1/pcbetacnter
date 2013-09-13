<?php 
$conf = array (
		'title' => $this->lang->line('user_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_users.user_name',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('user_name'),
						'field' => 'crud_users.user_name',
				),
				1 =>
				array (
						'alias' => $this->lang->line('group'),
						'field' => 'crud_users.group_id',
				),
				2 =>
				array (
						'alias' => $this->lang->line('first_name'),
						'field' => 'crud_users.user_first_name',
				),
				3 =>
				array (
						'alias' => $this->lang->line('last_name'),
						'field' => 'crud_users.user_las_name',
				),
				4 =>
				array (
						'alias' => $this->lang->line('email'),
						'field' => 'crud_users.user_email',
				),
		),
		'validate' =>
		array (
				'crud_users.user_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_name')),
				),
				'crud_users.user_password' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('user_password')),
				),
				'crud_users.user_email' =>
				array (
						0 =>
						array (
								'rule' => 'notEmpty',
								'message' => sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email')),
						),
						1 =>
						array (
								'rule' => 'email',
								'message' => sprintf($this->lang->line('please_provide_valid_email'), $this->lang->line('email')),
						),
				),
				'crud_users.user_first_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('first_name')),
				),
				'crud_users.user_las_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('last_name')),
				),
		),
		'data_list' =>
		array (
				'no' =>
				array (
						'alias' => $this->lang->line('no_'),
						'width' => 40,
						'align' => 'center',
						'format' => '{no}',
				),
				'crud_users.user_name' =>
				array (
						'alias' => $this->lang->line('user_name'),
						'width' => '150',
				),
				'crud_users.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'width' => '100',
						'align' => 'center',
				),
				'crud_users.user_first_name' =>
				array (
						'alias' => $this->lang->line('first_name'),
				),
				'crud_users.user_las_name' =>
				array (
						'alias' => $this->lang->line('last_name'),
						'width' => '210',
				),
				'crud_users.user_email' =>
				array (
						'alias' => $this->lang->line('email'),
						'width' => '150',
				),
				'crud_users.user_status' =>
				array (
						'alias' => $this->lang->line('status'),
						'width' => '60',
						'align' => 'center',
				),
				'action' =>
				array (
						'alias' => $this->lang->line('actions'),
						'format' => '<a type="button" onclick="__view(\'{ppri}\'); return false;" class="btn btn-mini">'.$this->lang->line('view').'</a> <a type="button" onclick="__edit(\'{ppri}\'); return false;" class="btn btn-mini btn-info">'.$this->lang->line('edit').'</a> <a type="button" onclick="__delete(\'{ppri}\'); return false;" class="btn btn-mini btn-danger">'.$this->lang->line('delete').'</a>',
						'width' => 130,
						'align' => 'center',
				),
		),
		'form_elements' =>
		array (
				'crud_users.user_name' =>
				array (
						'alias' => $this->lang->line('user_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_password' =>
				array (
						'alias' => $this->lang->line('user_password'),
						'element' =>
						array (
								0 => 'password',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'element' =>
						array (
								0 => 'select',
								1 =>
								array (
										'option_table' => 'crud_groups',
										'option_key' => 'id',
										'option_value' => 'group_name',
								),
						),
				),
				'crud_users.user_email' =>
				array (
						'alias' => $this->lang->line('email'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_first_name' =>
				array (
						'alias' => $this->lang->line('first_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_las_name' =>
				array (
						'alias' => $this->lang->line('last_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_status' =>
				array (
						'alias' => $this->lang->line('status'),
						'element' =>
						array (
								0 => 'radio',
								1 =>
								array (
										1 => 'Active',
										0 => 'InActive',
								),
						),
				),
				'crud_users.user_info' =>
				array (
						'alias' => $this->lang->line('user_information'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
		'elements' =>
		array (
				'crud_users.user_name' =>
				array (
						'alias' => $this->lang->line('user_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_password' =>
				array (
						'alias' => $this->lang->line('user_password'),
						'element' =>
						array (
								0 => 'password',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.group_id' =>
				array (
						'alias' => $this->lang->line('group'),
						'element' =>
						array (
								0 => 'select',
								1 =>
								array (
										'option_table' => 'crud_groups',
										'option_key' => 'id',
										'option_value' => 'group_name',
								),
						),
				),
				'crud_users.user_email' =>
				array (
						'alias' => $this->lang->line('email'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:210px;',
								),
						),
				),
				'crud_users.user_first_name' =>
				array (
						'alias' => $this->lang->line('first_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_las_name' =>
				array (
						'alias' => $this->lang->line('last_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:390px;',
								),
						),
				),
				'crud_users.user_status' =>
				array (
						'alias' => $this->lang->line('status'),
						'element' =>
						array (
								0 => 'radio',
								1 =>
								array (
										1 => $this->lang->line('active'),
										0 => $this->lang->line('inactive'),
								),
						),
				),
				'crud_users.user_info' =>
				array (
						'alias' => $this->lang->line('user_information'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
);