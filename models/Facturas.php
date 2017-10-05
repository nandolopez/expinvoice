<?php
class Facturas {
	public static function obtenerFacturas($inicio,$fin){
		$sql = "SELECT DISTINCT
		"._DB_PREFIX_."order_invoice.id_order_invoice,
		"._DB_PREFIX_."customer.firstname,
		"._DB_PREFIX_."customer.lastname,
		"._DB_PREFIX_."order_invoice.total_paid_tax_excl,
		"._DB_PREFIX_."order_invoice.total_paid_tax_incl,
		"._DB_PREFIX_."order_invoice.date_add,
		"._DB_PREFIX_."address.dni
		FROM  "._DB_PREFIX_."order_invoice
		INNER JOIN "._DB_PREFIX_."orders USING (id_order)
		INNER JOIN "._DB_PREFIX_."customer USING (id_customer)
		INNER JOIN "._DB_PREFIX_."address USING (id_customer)
		WHERE
		"._DB_PREFIX_."order_invoice.date_add between '".$inicio."' and '".$fin."' group by "._DB_PREFIX_."order_invoice.id_order_invoice
		order by "._DB_PREFIX_."order_invoice.id_order_invoice";
		return DB::getInstance()->executeS($sql);
	}
}

?>
