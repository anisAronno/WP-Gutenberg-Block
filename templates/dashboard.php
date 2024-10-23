<div class="wrap">
	<div class="heading">
		<h2><?php esc_html_e( 'Data table', 'flexibleDataTableBlock' ); ?></h2>
		<div>
			<?php wp_nonce_field( 'flexible_data_table_refresh_action' ); ?>
			<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'action', 'refresh', admin_url( 'admin.php?page=flexibleDataTableBlock' ) ), 'flexible_data_table_refresh_action' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Refresh Data', 'flexibleDataTableBlock' ); ?></a>
		</div>
	</div>
	<?php
		$flexible_data_table_list_table = new FlexibleDataTableBlock\Admin\List_Table();
		$flexible_data_table_list_table->prepare_items();
		$flexible_data_table_list_table->search_box( 'search', 'search_id' );
		$flexible_data_table_list_table->display();
	?>
</div>