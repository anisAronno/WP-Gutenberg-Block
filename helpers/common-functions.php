<?php

/**
 * Set Admin capability
 *
 * @since FLEXIBLEDATATABLEBLOCK_SINCE
 *
 * @return string
 */
function flexible_data_table_get_admin_capability() {
	return apply_filters( 'flexible_data_table_admin_capabilities', 'manage_options' );
}
