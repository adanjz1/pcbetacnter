<?php 
$conf = array (
		'title' => $this->lang->line('group_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_groups.group_name',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('group_name'),
						'field' => 'crud_groups.group_name',
				),
				1 =>
				array (
						'alias' => $this->lang->line('description'),
						'field' => 'crud_groups.group_description',
				),
		),
		'validate' =>
		array (
				'crud_groups.group_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('group_name')),
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
				'crud_groups.group_name' =>
				array (
						'alias' => $this->lang->line('group_name'),
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
				'crud_groups.group_name' =>
				array (
						'alias' => $this->lang->line('group_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:650px;',
								),
						),
				),
				'crud_groups.group_description' =>
				array (
						'alias' => $this->lang->line('description'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
		'elements' =>
		array (
				'crud_groups.group_name' =>
				array (
						'alias' => $this->lang->line('group_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:650px;',
								),
						),
				),
				'crud_groups.group_description' =>
				array (
						'alias' => $this->lang->line('description'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
);