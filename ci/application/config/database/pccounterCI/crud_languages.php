<?php
$conf = array (
		'title' => $this->lang->line('language_manager'),
		'limit' => '20',
		'frm_type' => '2',
		'join' =>
		array (
		),
		'order_field' => 'crud_languages.language_code',
		'order_type' => 'asc',
		'search_form' =>
		array (
				0 =>
				array (
						'alias' => $this->lang->line('language_code_m'),
						'field' => 'crud_languages.language_code',
				),
				1 =>
				array (
						'alias' => $this->lang->line('language_name'),
						'field' => 'crud_languages.language_name',
				),
		),
		'validate' =>
		array (
				'crud_languages.language_code' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('language_code_m')),
				),
				'crud_languages.language_name' =>
				array (
						'rule' => 'notEmpty',
						'message' => sprintf($this->lang->line('please_enter_value'), $this->lang->line('language_name')),
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
				'crud_languages.language_code' =>
				array (
						'alias' => $this->lang->line('language_code_m'),
						'width' => '200',
				),
				'crud_languages.language_name' =>
				array (
						'alias' => $this->lang->line('language_name'),
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
				'crud_languages.language_code' =>
				array (
						'alias' => $this->lang->line('language_code_m'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:50px;',
								),
						),
				),
				'crud_languages.language_name' =>
				array (
						'alias' => $this->lang->line('language_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:342px;',
								),
						),
				),
		),
		'elements' =>
		array (
				'crud_languages.language_code' =>
				array (
						'alias' => $this->lang->line('language_code_m'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:50px;',
								),
						),
				),
				'crud_languages.language_name' =>
				array (
						'alias' => $this->lang->line('language_name'),
						'element' =>
						array (
								0 => 'text',
								1 =>
								array (
										'style' => 'width:342px;',
								),
						),
				),
		),
);