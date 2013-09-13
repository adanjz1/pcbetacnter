<?php
$conf = array (
		'title' => $this->lang->line('group_component_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_group_components.id',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('name'),
						'field' => 'crud_group_components.name',
				),
		),
		'validate' =>
		array (
				'crud_group_components.name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('name')),
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
				'crud_group_components.name' =>
				array (
						'alias' => $this->lang->line('name'),
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
				'crud_group_components.name' =>
				array (
						'alias' => $this->lang->line('name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:410px;',
								),
						),
				),
				'crud_group_components.description' =>
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
				'crud_group_components.name' =>
				array (
						'alias' => $this->lang->line('name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:410px;',
								),
						),
				),
				'crud_group_components.description' =>
				array (
						'alias' => $this->lang->line('description'),
						'element' =>
						array (
								0 => 'editor',
						),
				),
		),
);