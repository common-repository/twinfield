<h2><?php _e( 'Invoice Form', 'twinfield' ); ?></h2>
<form method="POST" class="input-form">
	<?php echo $nonce; ?>
	<table class="form-table">
		<tr>
			<th><?php _e( 'Invoice Type', 'twinfield' ); ?></th>
			<td>
				<input type="text" name="invoiceType" value="<?php echo $object->getInvoiceType(); ?>"/>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Customer ID', 'twinfield' ); ?></th>
			<td>
				<input type="text" name="customerID" value="<?php echo $object->getCustomer()->getID(); ?>"/>
			</td>
		</tr>
	</table>
	<br/>
	<table class="widefat">
		<thead>
			<th><?php _e( 'Article', 'twinfield' ); ?></th>
			<th><?php _e( 'Subarticle', 'twinfield' ); ?></th>
			<th><?php _e( 'Quantity', 'twinfield' ); ?></th>
			<th><?php _e( 'Units', 'twinfield' ); ?></th>
			<th><?php _e( 'Units Excl', 'twinfield' ); ?></th>
			<th><?php _e( 'Vatcode', 'twinfield' ); ?></th>
			<th><?php _e( 'Free Text 1', 'twinfield' ); ?></th>
			<th><?php _e( 'Free Text 2', 'twinfield' ); ?></th>
			<th><?php _e( 'Free Text 3', 'twinfield' ); ?></th>
		</thead>
		<tbody class="jFormBuilderUI_TableBody">
			<?php $lines = $object->getLines(); ?>
			<?php if ( ! empty( $lines ) ) : ?>
				<?php $line_number = 1; ?>
				<?php foreach ( $object->getLines() as $line ) : ?>
					<tr data-number="<?php echo $line_number; ?>">
						<input type="hidden" name="lines[<?php echo $line_number; ?>][active]" value="true" />
						<td><input type="text" name="lines[<?php echo $line_number; ?>][article]" value="<?php echo $line->getArticle(); ?>"/></td>
						<td><input type="text" name="lines[<?php echo $line_number; ?>][subarticle]" value="<?php echo $line->getSubArticle(); ?>"/></td>
						<td><input type="text" name="lines[<?php echo $line_number; ?>][quantity]" value="<?php echo $line->getQuantity(); ?>"/></td>
						<td><input type="text" name="lines[<?php echo $line_number; ?>][units]" value="<?php echo $line->getUnits(); ?>"/></td>
						<td><input type="text" name="lines[<?php echo $line_number; ?>][unitspriceexcl]" value="<?php echo $line->getUnitsPriceExcl(); ?>"/></td>
						<td><input type="text" name="lines[<?php echo $line_number; ?>][vatcode]" value="<?php echo $line->getVatCode(); ?>"/></td>
						<td><textarea name="lines[<?php echo $line_number; ?>][freetext1]"><?php echo $line->getFreeText1(); ?></textarea></td>
						<td><textarea name="lines[<?php echo $line_number; ?>][freetext2]"><?php echo $line->getFreeText2(); ?></textarea></td>
						<td><textarea name="lines[<?php echo $line_number; ?>][freetext3]"><?php echo $line->getFreeText3(); ?></textarea></td>
					</tr>
					<?php $line_number++; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<tr data-number="1">
					<input type="hidden" name="lines[1][active]" value="true" />
					<td><input type="text" name="lines[1][article]" value=""/></td>
					<td><input type="text" name="lines[1][subarticle]" value=""/></td>
					<td><input type="text" name="lines[1][quantity]" value=""/></td>
					<td><input type="text" name="lines[1][units]" value=""/></td>
					<td><input type="text" name="lines[1][unitspriceexcl]" value=""/></td>
					<td><input type="text" name="lines[1][vatcode]" value=""/></td>
					<td><textarea name="lines[1][freetext1]"></textarea></td>
					<td><textarea name="lines[1][freetext2]"></textarea></td>
					<td><textarea name="lines[1][freetext3]"></textarea></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<br/>
	<a href="#" class="jAddLine">Add Line</a>
	<input type="submit" value="Send" class="button button-primary" style="float:right;"/>
</form>