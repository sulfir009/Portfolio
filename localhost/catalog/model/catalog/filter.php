<?php

class ModelCatalogFilter extends Model
{

	public function getFilters()
	{
		$query = $this->db->query("
				SELECT f.filter_id, fd.name
				FROM " . DB_PREFIX . "filter f
				LEFT JOIN " . DB_PREFIX . "filter_description fd ON 
					f.filter_id = fd.filter_id AND 
					fd.language_id = '" . (int)$this->config->get('config_language_id') . "'
				WHERE f.filter_group_id = 1
				ORDER BY fd.name
			");

		return $query->rows;
	}

}