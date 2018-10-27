<?php $this->load->view("partial/header"); ?>

<?php echo form_open_multipart('items/save/'.(!isset($is_clone) ? $item_info->item_id : ''),array('id'=>'item_form','class'=>'form-horizontal')); ?>
<?php echo form_hidden('ecommerce_product_id', $item_info->ecommerce_product_id); ?>

<div class="row" id="form">
	<div class="spinner" id="grid-loader" style="display:none">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	</div>
	<div class="col-md-12">

	<div class="panel panel-piluku">
		<div class="panel-heading">
                <h3 class="panel-title">
                    <i class="ion-edit"></i> 
                    	<?php echo lang("items_basic_information"); ?>
						<small>(<?php echo lang('common_fields_required_message'); ?>)</small>
                </h3>
        </div>

			<div class="panel-body">
				<div class="item_navigation clearfix text-center">
					<ul class="list-inline">
						<li>
							<?php
							if (isset($prev_item_id) && $prev_item_id)
							{
								echo '<div class="previous_item">';
									echo anchor('items/view/'.$prev_item_id, '&laquo; '.lang('items_prev_item'), 'class="btn btn-green btn-round"');
								echo '</div>';
							}
							?>
						</li>
						<li>
							<?php
							if (isset($next_item_id) && $next_item_id)
							{
								echo '<div class="next_item">';
									echo anchor('items/view/'.$next_item_id,lang('items_next_item').' &raquo;', 'class="btn btn-green btn-round"');
								echo '</div>';
							}
							?>
						</li>
					</ul>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('common_item_number_expanded').':', 'item_number',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'item_number',
							'id'=>'item_number',
							'class'=>'form-control form-inps',
							'value'=>$item_info->item_number)
						);?>
					</div>
				</div>
               
                <div class="form-group">
					<?php echo form_label(lang('common_product_id').':', 'product_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label required wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'product_id',
							'id'=>'product_id',
							'class'=>'form-control form-inps',
							'value'=>$item_info->product_id)
						);?>
					</div>
				</div>
				
				<div class="form-group hide">	
					<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo lang('items_additional_item_numbers') ?></label>
					<div class="col-sm-9 col-md-3 col-lg-3">
						<table id="additional_item_numbers" class="table">
							<thead>
								<tr>
								<th><?php echo lang('common_item_number'); ?></th>
								<th><?php echo lang('common_delete'); ?></th>
								</tr>
							</thead>
							
							<tbody>
								<?php if (isset($additional_item_numbers) && $additional_item_numbers) {?>
									<?php foreach($additional_item_numbers->result() as $additional_item_number) { ?>
										<tr><td><input type="text" class="form-control form-inps" size="50" name="additional_item_numbers[]" value="<?php echo H($additional_item_number->item_number); ?>" /></td><td>
										<a class="delete_item_number" href="javascript:void(0);"><?php echo lang('common_delete'); ?></a>
									</td></tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
						<a href="javascript:void(0);" id="add_addtional_item_number"><?php echo lang('items_add_item_number'); ?></a>
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('common_item_name').':', 'name',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label required wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'name',
							'id'=>'name',
							'class'=>'form-control form-inps',
							'value'=>$item_info->name)
						);?>
					</div>
				</div>


				<div class="form-group">
					<?php echo form_label(lang('common_category').':', 'category_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label  required wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('category_id', $categories,$item_info->category_id, 'class="form-control form-inps" id ="category_id"');?>
						<?php if ($this->Employee->has_module_action_permission('items', 'manage_categories', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
								<div>
									<?php echo anchor("items/categories",lang('items_manage_categories'),array('target' => '_blank', 'title'=>lang('items_manage_categories')));?>
								</div>
						<?php } ?>		
					</div>
					
				</div>
				
				
				<div class="form-group">
					<?php echo form_label(lang('common_tags').':', 'tags',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'tags',
							'id'=>'tags',
							'class'=>'form-control form-inps',
							'value' => $tags,
						));?>
						<?php if ($this->Employee->has_module_action_permission('items', 'manage_tags', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
								<div>
									<?php echo anchor("items/manage_tags",lang('items_manage_tags'),array('target' => '_blank', 'title'=>lang('items_manage_tags')));?>
								</div>
						<?php } ?>
					</div>
				</div>
				
				<div class="form-group">

					<?php echo form_label(lang('common_unit').':', 'unit_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('unit_id', $units, $selected_unit,'class="form-control" id="unit_id"');?>
						<div>
							<?php echo anchor("items/manage_units",lang('common_manage_units'),array('target' => '_blank', 'title'=>lang('common_manage_units')));?>
						</div>
						
					</div>
				</div>

				<!-- add file coefficient -->
				<div class="form-group">
					<?php echo form_label(lang('Hệ Số').':', 'coefficient_item',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'coefficient',
							'id'=>'coefficient',
							'type' => 'number',
							'class'=>'form-control form-inps',
							'value'=>$item_info->coefficient)
						);?>		
					</div>
				</div>

				<!-- end -->

				<div class="form-group hide">
					<?php echo form_label(lang('common_size').':', 'size',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'size',
							'id'=>'size',
							'class'=>'form-control form-inps',
							'value'=>$item_info->size)
						);?>
					</div>
				</div>

				<div class="form-group hide">
					<?php echo form_label(lang('common_supplier').':', 'supplier_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide '.(!$item_info->item_id ? 'required' : ''))); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('supplier_id', $suppliers, $selected_supplier,'class="form-control" id="supplier_id"');?>
					</div>
				</div>
				<!-- <?php echo '<pre>';
					print_r($suppliers);
					echo "</pre>";
				?> -->
				<div class="form-group">
					<?php echo form_label(lang('common_supplier').':', 'supplier_ids',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'suppliers',
							'id'=>'suppliers',
							'class'=>'form-control form-inps',
						    'value' => $selected_suppliers,
						));?>
					</div>
				</div>
				<!-- add files customers -->

				<div class="form-group hide">
					<?php echo form_label(lang('common_customer').':', 'customer_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide '.(!$item_info->item_id ? 'required' : ''))); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('customer_id', $customers, $selected_customer,'class="form-control" id="customer_id"');?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo form_label(lang('common_customer').':', 'customer_ids',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'customers',
							'id'=>'customers',
							'class'=>'form-control form-inps',
						    'value' => $selected_customers,
						));?>
					</div>
				</div>

				<!-- end files customers -->
				<div class="form-group">
					<?php echo form_label(lang('common_manufacturer').':', 'manufacturer_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('manufacturer_id', $manufacturers, $selected_manufacturer,'class="form-control" id="manufacturer_id"');?>
						
						<?php if ($this->Employee->has_module_action_permission('items', 'manage_manufacturers', $this->Employee->get_logged_in_employee_info()->person_id)) {?>
						<div>
							<?php echo anchor("items/manage_manufacturers",lang('common_manage_manufacturers'),array('target' => '_blank', 'title'=>lang('common_manage_manufacturers')));?>
						</div>
						<?php } ?>
						
					</div>
				</div>
				<div class="form-group hide reorder-input <?php if ($item_info->is_service){echo 'hidden';} ?>">
					<?php echo form_label(lang('items_reorder_level').':', 'reorder_level',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'reorder_level',
							'id'=>'reorder_level',
							'class'=>'form-control form-inps',
							'value'=>$item_info->reorder_level ? to_quantity($item_info->reorder_level) :'')
						);?>
					</div>
				</div>				
				<div class="form-group hide">
					<?php echo form_label(lang('items_days_to_expiration').':', 'size',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'expire_days',
							'id'=>'expire_days',
							'class'=>'form-control form-inps',
							'value'=>$item_info->expire_days)
						);?>
					</div>
				</div>

				<div class="form-group">
					<?php echo form_label(lang('common_description').':', 'description',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_textarea(array(
							'name'=>'description',
							'id'=>'description',
							'value'=>$item_info->description,
							'class'=>'form-control  text-area',
							'rows'=>'5',
							'cols'=>'17')
						);?>
					</div>
				</div>
				
				<div class="form-group">
					<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Lượng tồn tối thiểu:</label>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" class="form-control form-inps" name="limit" value="<?php echo $item_info->limit;?>">
					</div>
				</div>
				
				<div class="form-group">
					<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Tỉ lệ hao hụt:</label>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" class="form-control form-inps" name="buffer_rate" value="<?php echo $item_info->buffer_rate;?>">
					</div>
				</div>

				<div class="form-group hide">
					<?php echo form_label(lang('common_prices_include_tax').':', 'tax_included',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'tax_included',
							'id'=>'tax_included',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->tax_included || (!$item_info->item_id && $this->config->item('prices_include_tax'))) ? 1 : 0)
						);?>
						<label for="tax_included"><span></span></label>
					</div>
				</div>

				<div class="form-group hide">
					<?php echo form_label(lang('items_is_service').':', 'is_service',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'is_service',
							'id'=>'is_service',
								'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->is_service || (!$item_info->item_id && $this->config->item('default_new_items_to_service'))) ? 1 : 0)
						);?>
						<label for="is_service"><span></span></label>
					</div>
				</div>
				
				<?php if ($this->config->item("ecommerce_platform")) { ?>
				<div class="form-group">
					<?php echo form_label(lang('items_is_ecommerce').':', 'is_ecommerce',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'is_ecommerce',
							'id'=>'is_ecommerce',
								'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->is_ecommerce || (!$item_info->item_id)) ? 1 : 0)
						);?>
						<label for="is_ecommerce"><span></span></label>
					</div>
				</div>
				<?php } ?>
				<div class="form-group hide">
					<?php echo form_label(lang('items_allow_alt_desciption').':', 'allow_alt_description',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'allow_alt_description',
							'id'=>'allow_alt_description',
							'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->allow_alt_description)? 1  :0)
						);?>
						<label for="allow_alt_description"><span></span></label>
					</div>
				</div>

				<div class="form-group hide">
					<?php echo form_label(lang('items_is_serialized').':', 'is_serialized',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'is_serialized',
							'id'=>'is_serialized',
								'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->is_serialized)? 1 : 0)
						);?>
						<label for="is_serialized"><span></span></label>
					</div>
				</div>
				
				<div id="serial_container" class="form-group serial-input hide <?php if (!$item_info->is_serialized){echo 'hidden';} ?>">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label"><?php echo lang('items_serial_numbers') ?></label>
					<div class="col-sm-9 col-md-3 col-lg-3">
				
					<table id="serial_numbers" class="table">
						<thead>
							<tr>
							<th><?php echo lang('items_serial_number'); ?></th>
							<th><?php echo lang('common_price'); ?></th>
							<th><?php echo lang('common_delete'); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php if (isset($serial_numbers) && $serial_numbers) {?>
								<?php foreach($serial_numbers->result() as $serial_item_number) { ?>
								<tr>
									<td><input type="text" class="form-control form-inps" size="40" name="serial_numbers[]" value="<?php echo H($serial_item_number->serial_number); ?>" /></td>
									<td><input type="text" class="form-control form-inps" size="20" name="serial_number_prices[]" value="<?php echo H($serial_item_number->unit_price !== NULL ? to_currency_no_money($serial_item_number->unit_price) : ''); ?>" /></td>
									<td><a class="delete_serial_number" href="javascript:void(0);"><?php echo lang('common_delete'); ?></a></td>
								</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				
					<a href="javascript:void(0);" id="add_serial_number"><?php echo lang('items_add_serial_number'); ?></a>
					
				</div>
			</div>
				
				<?php
				if (0 && $this->config->item('enable_customer_loyalty_system') && $this->config->item('loyalty_option') == 'advanced')
				{
				?>
				
				<div class="form-group">
					<?php echo form_label(lang('common_disable_loyalty').':', 'disable_loyalty',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'disable_loyalty',
							'id'=>'disable_loyalty',
								'class'=>'delete-checkbox',
							'value'=>1,
							'checked'=>($item_info->disable_loyalty)? 1 : 0)
						);?>
						<label for="disable_loyalty"><span></span></label>
					</div>
				</div>
				
				<?php
				}
				?>
				
				<div class="form-group hide">
	      	<?php echo form_label(lang('common_select_images').':', 'image_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label ')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
        	        	<div class="image-upload">
        	          	<input type="file" name="image_files[]" id="image_id" class="filestyle" data-icon="false" multiple accept="image/png,image/gif,image/jpeg" >  
        	           </div>    
        	        </div> 
				</div>
				
				<div id="image_preview" class="item_image_preview hide"></div>
						
				<div id="image_well" class="well hide">
					<?php if($item_images) { ?>
						
					<?php if($this->agent->is_mobile()) { ?>
					<div class="row">
					<?php } else { ?>
					<div class="row equal">
					<?php }?>
						
					<?php 
					$i = 0;
					foreach($item_images as $item_image) { 
						$i ++;
					?>
							<div class="col-lg-4 col-md-4 col-xs-12">
								<div class="panel panel-default panel-equal">
								  <div class="panel-heading"><?php echo lang('items_image_details') ?> <i class="glyphicon glyphicon-pencil pull-right"></i></div>
								  <div class="panel-body">
										<div class="form-group">
											<?php echo form_label(lang('common_del_image').':', 'del_image',array('class'=>'col-sm-9 col-md-9 col-lg-8 control-label')); ?>
								
											<?php echo form_checkbox(array(
												'name'=>'del_images['.$item_image['image_id'].']',
												'id'=>'del_image_'.$item_image['image_id'],
												'class'=>'delete-checkbox',
												'value'=>1
											));?>
											<label for="del_image_<?php echo $item_image['image_id']; ?>"><span></span></label>		 
										</div>
									
										<div class="thumbnail">
											<?php echo img(array('src' => app_file_url($item_image['image_id']),'class'=>'img-polaroid img-polaroid-s')); ?>
										</div>
									
										<?php echo form_label(lang('items_image_title').':', 'item_image_title',array('class'=>'control-label')); 
										$data = array(
										        'name'          => 'titles['.$item_image['image_id'].']',
										        'id'            => 'titles_'.$item_image['image_id'],
										        'placeholder'   => lang('items_enter_a_title'),
										        'class'         => 'form-control',
														'value'					=> $item_image['title'],
														
										);

										echo form_input($data);
																		
										echo form_label(lang('items_image_alt_text').':', 'item_image_alt_text',array('class'=>'control-label'));
									
										$data = array(
										        'name'          => 'alt_texts['.$item_image['image_id'].']',
										        'id'            => 'alt_texts_'.$item_image['image_id'],
										        'placeholder'   => lang('items_enter_alt_text'),
										        'class'         => 'form-control',
														'value'					=> $item_image['alt_text'],
										);

										echo form_input($data);
																					
										?>
								  </div>
								</div>
							</div>
					<?php 
							if($i % 3 == 0)
							{
					?>
								</div>
								<?php if($this->agent->is_mobile()) { ?>
								<div class="row">
								<?php } else { ?>
								<div class="row equal">
								<?php }?>
					<?php
							}
						} ?>
					</div>
				<?php } else { ?>
					<h4 class="well-text text-center" ><i style="font-size: 2.5em" class="glyphicon glyphicon-camera"></i></h4>
				<?php } ?>
				</div>
				
			</div><!--/panel-body -->
		</div><!-- /panel-piluku -->


		<div class="panel panel-piluku">
			<div class="panel-heading pricing-widget">
				<?php echo lang("items_pricing_and_inventory"); ?>
			</div>
			<div class="panel-body">
				<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
					<div class="form-group">
						<?php echo form_label(lang('common_cost_price').' ('.lang('common_without_tax').')'.':', 'cost_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'cost_price',
								'size'=>'8',
								'id'=>'cost_price',
								'class'=>'form-control form-inps',
								'value'=>$item_info->cost_price ? to_currency_no_money($item_info->cost_price,10) : '')
							);?>
						</div>
					</div>
				<?php 
				}
				else
				{
					echo form_hidden('cost_price', $item_info->cost_price);
				}
				?>
				
				<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
				
				
				<div class="form-group hide">
					<?php echo form_label(lang('common_change_cost_price_during_sale').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'change_cost_price',
							'id'=>'change_cost_price',
							'class' => 'delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->change_cost_price))));
						?>
						<label for="change_cost_price"><span></span></label>
					</div>
				</div>
				<?php } elseif($item_info->change_cost_price) { 
					echo form_hidden('change_cost_price', 1);
				?>
					
				<?php } ?>
				<?php if ($this->Employee->has_module_action_permission('items','see_cost_price', $this->Employee->get_logged_in_employee_info()->person_id) or $item_info->name=="") { ?>
					
				<?php if ($this->config->item('enable_margin_calculator')) { ?>
				<div class="form-group hide">
					<?php echo form_label(lang('common_margin').':', 'margin',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
					    <?php echo form_input(array(
					        'name'=>'margin',
					        'size'=>'8',
							'class'=>'form-control',
					        'id'=>'margin',
					        'value'=>'',
							  'placeholder' => lang('common_enter_margin_percent'),
							)
					    );?>
						 
				    </div>
				</div>
				<?php } ?>
				<?php } ?>
				<div class="form-group hide">
					<?php echo form_label(lang('common_unit_price').':', 'unit_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_input(array(
							'name'=>'unit_price',
							'size'=>'8',
							'id'=>'unit_price',
									'class'=>'form-control form-inps',
							'value'=>$item_info->unit_price ? to_currency_no_money($item_info->unit_price, 10) : '')
						);?>
					</div>
				</div>
				
				
				<?php
				if ($this->config->item('enable_ebt_payments')) { ?>
					<div class="form-group hide">
					
					<?php echo form_label(lang('common_is_ebt_item').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo form_checkbox(array(
						'name'=>'is_ebt_item',
						'id'=>'is_ebt_item',
						'class' => 'is_ebt_item delete-checkbox',
						'value'=>1,
						'checked'=>(boolean)(($item_info->is_ebt_item))));
					?>
					<label for="is_ebt_item"><span></span></label>
				</div>
			</div>
			<?php } ?>
				<?php foreach($tiers as $tier) { ?>	
					<div class="form-group hide">
						<?php echo form_label($tier->name.':', 'tier_'.$tier->id,array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'item_tier['.$tier->id.']',
								'size'=>'8',
								'id'=>'tier_'.$tier->id,
								'class'=>'form-control form-inps margin10',
								'value'=> $tier_prices[$tier->id] !== FALSE ? ($tier_prices[$tier->id]->unit_price != NULL ? to_currency_no_money($tier_prices[$tier->id]->unit_price, 10) : to_quantity(($tier_prices[$tier->id]->percent_off != NULL ) ? $tier_prices[$tier->id]->percent_off : $tier_prices[$tier->id]->cost_plus_percent )): '')
							);?>

							<?php 
							
							$selected_tier_type_option = '';
							
							if ($tier_prices[$tier->id] !== FALSE)
							{
								if ($tier_prices[$tier->id]->unit_price !== NULL)
								{
									$selected_tier_type_option = 'unit_price';
									
								}
								elseif($tier_prices[$tier->id]->percent_off !== NULL)
								{
									$selected_tier_type_option = 'percent_off';									
								}
								else
								{
									$selected_tier_type_option = 'cost_plus_percent';									
								}
							}
							
							echo form_dropdown('tier_type['.$tier->id.']', $tier_type_options, $selected_tier_type_option,'class="form-control"');?>
						</div>
					</div>
				<?php } ?>

				<div class="form-group hide">
					<?php echo form_label(lang('items_promo_price').':', 'promo_price',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
				    <div class="col-sm-9 col-md-9 col-lg-10">
					    <?php echo form_input(array(
					        'name'=>'promo_price',
					        'size'=>'8',
							'class'=>'form-control',
					        'id'=>'promo_price',
					        'value'=> $item_info->promo_price ? to_currency_no_money($item_info->promo_price,10) : '')
					    );?>
				    </div>
				</div>

				<div class="form-group offset1 hide">
					<?php echo form_label(lang('items_promo_start_date').':', 'start_date',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
					    <div class="input-group date" data-date="<?php echo $item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : ''; ?>">
							<span class="input-group-addon bg">
	                           <i class="ion ion-ios-calendar-outline"></i>
	                       	</span>
							<?php echo form_input(array(
						        'name'=>'start_date',
						        'id'=>'start_date',
								'class'=>'form-control datepicker',
						        'value'=>$item_info->start_date ? date(get_date_format(), strtotime($item_info->start_date)) : '')
						    );?> 
					    </div>
				    </div>
				</div>

				<div class="form-group offset1 hide">
					<?php echo form_label(lang('items_promo_end_date').':', 'end_date',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label text-info wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
					    <div class="input-group date" data-date="<?php echo $item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : ''; ?>">
							<span class="input-group-addon bg">
	                           <i class="ion ion-ios-calendar-outline"></i>
	                       	</span>
							<?php echo form_input(array(
						        'name'=>'end_date',
						        'id'=>'end_date',
										'class'=>'form-control form-inps datepicker',
						        'value'=>$item_info->end_date ? date(get_date_format(), strtotime($item_info->end_date)) : '')
						    );?> 
						</div>
				    </div>
				</div>				

				<div class="form-group override-commission-container hide">
					<?php echo form_label(lang('common_override_default_commission').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'override_default_commission',
							'id'=>'override_default_commission',
							'class' => 'override_default_commission delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)(($item_info->commission_percent != '') || ($item_info->commission_fixed != ''))));
						?>
						<label for="override_default_commission"><span></span></label>
					</div>
				</div>

				<div class="commission-container hide <?php if (!($item_info->commission_percent != '') && !($item_info->commission_fixed != '')){echo 'hidden';} ?>">
					<div class="form-group">
						<?php echo form_label(lang('reports_commission'), 'commission_value',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class='col-sm-9 col-md-9 col-lg-10'>
							<?php echo form_input(array(
								'name'=>'commission_value',
								'id'=>'commission_value',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps', 
								'value'=> $item_info->commission_fixed != '' ? to_quantity($item_info->commission_fixed, FALSE) : to_quantity($item_info->commission_percent, FALSE))
							);?>
							
							<?php echo form_dropdown('commission_type', array('percent' => lang('common_percentage'), 'fixed' => lang('common_fixed_amount')), $item_info->commission_fixed != '' ? 'fixed' : 'percent', 'id="commission_type"');?>
						</div>
					</div>
					
					<div class="form-group" id="commission-percent-calculation-container">	
						<?php echo form_label(lang('common_commission_percent_calculation').': ', 'commission_percent_type',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_dropdown('commission_percent_type', array(
							'selling_price'  => lang('common_unit_price'),
							'profit'    => lang('common_profit'),
							),
							$item_info->commission_percent_type,
							array('id' =>'commission_percent_type'))
							?>
						</div>
					</div>
				</div>
			
				<div class="form-group override-taxes-container hide">
					<?php echo form_label(lang('common_override_default_tax').':', '',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<?php echo form_checkbox(array(
							'name'=>'override_default_tax',
							'id'=>'override_default_tax',
							'class' => 'override_default_tax_checkbox delete-checkbox',
							'value'=>1,
							'checked'=>(boolean)$item_info->override_default_tax));
						?>
						<label for="override_default_tax"><span></span></label>
					</div>
				</div>

				<div class="tax-container main hide <?php if (!$item_info->override_default_tax){echo 'hidden';} ?>">	
					<div class="form-group">
						<?php echo form_label(lang('common_tax_1').':', 'tax_percent_1',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_1',
								'size'=>'8',
								'class'=>'form-control margin10 form-inps',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[0]['name']) ? $item_tax_info[0]['name'] : ($this->Location->get_info_for_key('default_tax_1_name') ? $this->Location->get_info_for_key('default_tax_1_name') : $this->config->item('default_tax_1_name')))
							);?>
						</div>
	                    <label class="col-sm-3 col-md-3 col-lg-2 control-label wide" for="tax_percent_name_1">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_1',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[0]['percent']) ? $item_tax_info[0]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
						</div>
					</div>

					<div class="form-group">
						<?php echo form_label(lang('common_tax_2').':', 'tax_percent_2',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_2',
								'size'=>'8',
								'class'=>'form-control form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[1]['name']) ? $item_tax_info[1]['name'] : ($this->Location->get_info_for_key('default_tax_2_name') ? $this->Location->get_info_for_key('default_tax_2_name') : $this->config->item('default_tax_2_name')))
							);?>
						</div>
	                    <label class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">&nbsp;</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_2',
								'size'=>'3',
								'class'=>'form-control form-inps-tax',
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[1]['percent']) ? $item_tax_info[1]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_checkbox('tax_cumulatives[]', '1', (isset($item_tax_info[1]['cumulative']) && $item_tax_info[1]['cumulative']) ? (boolean)$item_tax_info[1]['cumulative'] : (boolean)$this->config->item('default_tax_2_cumulative'), 'class="cumulative_checkbox" id="tax_cumulatives"'); ?>
							<label for="tax_cumulatives"><span></span></label>
						    <span class="cumulative_label">
								<?php echo lang('common_cumulative'); ?>
						    </span>
						</div>
					</div>
	                 
					<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3"  style="visibility: <?php echo isset($item_tax_info[2]['name']) ? 'hidden' : 'visible';?>">
						<a href="javascript:void(0);" class="show_more_taxes"><?php echo lang('common_show_more');?> &raquo;</a>
					</div>
					<div class="more_taxes_container" style="display: <?php echo isset($item_tax_info[2]['name']) ? 'block' : 'none';?>">
						<div class="form-group">
							<?php echo form_label(lang('common_tax_3').':', 'tax_percent_3',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_3',
									'size'=>'8',
									'class'=>'form-control form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($item_tax_info[2]['name']) ? $item_tax_info[2]['name'] : ($this->Location->get_info_for_key('default_tax_3_name') ? $this->Location->get_info_for_key('default_tax_3_name') : $this->config->item('default_tax_3_name')))
								);?>
							</div>
	                        <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_3',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($item_tax_info[2]['percent']) ? $item_tax_info[2]['percent'] : '')
								);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>

						<div class="form-group">
						<?php echo form_label(lang('common_tax_4').':', 'tax_percent_4',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_names[]',
								'id'=>'tax_percent_4',
								'size'=>'8',
								'class'=>'form-control  form-inps margin10',
								'placeholder' => lang('common_tax_name'),
								'value'=> isset($item_tax_info[3]['name']) ? $item_tax_info[3]['name'] : ($this->Location->get_info_for_key('default_tax_4_name') ? $this->Location->get_info_for_key('default_tax_4_name') : $this->config->item('default_tax_4_name')))
							);?>
							</div>
	                        <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
							<?php echo form_input(array(
								'name'=>'tax_percents[]',
								'id'=>'tax_percent_name_4',
								'size'=>'3',
								'class'=>'form-control form-inps-tax', 
								'placeholder' => lang('common_tax_percent'),
								'value'=> isset($item_tax_info[3]['percent']) ? $item_tax_info[3]['percent'] : '')
							);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>
						
						<div class="form-group">
						<?php echo form_label(lang('common_tax_5').':', 'tax_percent_5',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_names[]',
									'id'=>'tax_percent_5',
									'size'=>'8',
									'class'=>'form-control  form-inps margin10',
									'placeholder' => lang('common_tax_name'),
									'value'=> isset($item_tax_info[4]['name']) ? $item_tax_info[4]['name'] : ($this->Location->get_info_for_key('default_tax_5_name') ? $this->Location->get_info_for_key('default_tax_5_name') : $this->config->item('default_tax_5_name')))
								);?>
							</div>
	                        <label class="col-sm-3 col-md-3 col-lg-2 control-label wide">&nbsp;</label>
							<div class="col-sm-9 col-md-9 col-lg-10">
								<?php echo form_input(array(
									'name'=>'tax_percents[]',
									'id'=>'tax_percent_name_5',
									'size'=>'3',
									'class'=>'form-control form-inps-tax margin10',
									'placeholder' => lang('common_tax_percent'),
									'value'=> isset($item_tax_info[4]['percent']) ? $item_tax_info[4]['percent'] : '')
								);?>
							<div class="tax-percent-icon">%</div>
							<div class="clear"></div>
							<?php echo form_hidden('tax_cumulatives[]', '0'); ?>
							</div>
						</div>
					</div> <!--End more Taxes Container-->
	                <div class="clear"></div>
				</div>
			</div><!-- /panel-body-->
		</div><!--/panel-piluku-->
		<div class="panel panel-piluku">
			<div class="panel-heading">
                <h3 class="panel-title">
                    <i class="ion-edit"></i> Bán thành phẩm
                </h3>
        	</div>
        	<div class="panel-body">
        		<div class="row" style="margin-top:10px;">
        			<div class="col-md-6">
        				<autocomplete :resource="resource" :refresh="true" v-on:onselected="on_selected"></autocomplete>
    				</div>
				</div>
        		
        		<div class="row" style="margin-top:10px;">
    				<div class="col-md-12">
    					<table class="tablesorter table table-hover table-bordered">
                    	<thead>
                    		<tr>
                    			<th>STT</th>
                    			<th>Quy cách (tên gọi)</th>
                    			<th>Mã vật tư</th>
                    			<th>Nhà sản xuất</th>
                    			<th>Đơn vị tính</th>
                    			<th style="width: 150px;">Số lượng</th>
                    			<th style="width: 50px;"></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<tr style="cursor: pointer;" v-for="(record, i) in selected_items">
                    			<td>{{i + 1}}</td>
                    			<td>{{record.name | displayValue}}</td>
                    			<td>{{record.product_id | displayValue}}</td>
                    			<td>{{record.manufacturer | displayValue}}</td>
                    			<td>{{record.unit | displayValue}}</td>
                    			<td>
                    				<input v-bind:name="build_input_name(record)" style="width: 100%;" v-model="selected_items[i].qty"/>
                    			</td>
                    			<td>
                    				<button type="button" class="btn btn-default" @click="remove_item(i)">
										<span class="icon ti-trash" aria-hidden="true"></span>
									</button>
                    			</td>
                    		</tr>
                    	</tbody>
                        </table>
    				</div>
				</div>
        	</div>
		</div>
		
		<div class="panel panel-piluku">
			<div class="panel-heading">
                <h3 class="panel-title">
                    <i class="ion-edit"></i> Thuộc tính
                </h3>
        	</div>
        	<div class="panel-body">
        		<div class="form-group">
					<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Nhóm thuộc tính:</label>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="attr_group_id" id="attr_group_id" class="form-control form-inps" v-model="selected_attr_group" @change="select_attr_group()">
							<?php foreach ($attr_groups as $id => $attr_group) {?>
    						<option value="<?php echo $id;?>"><?php echo $attr_group;?></option>
    						<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group" v-for="(attribute, i) in attributes">
					<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">{{attribute.name}}:</label>
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" v-bind:name="build_attr_input_name(attribute)" class="form-control form-inps" v-model="attribute.value">
					</div>
				</div>
        	</div>
		</div>
		
		<div class="panel panel-piluku">
			<div class="">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
				<?php foreach($locations as $i => $location) {
					$cur_quantity = $location_items[$location->location_id]->item_id !== '' && $location_items[$location->location_id]->quantity !== NULL ? to_quantity($location_items[$location->location_id]->quantity): '0'; ?>
					<div class="">
						<div class="panel-heading" role="tab" id="heading<?php echo $i;?>">
							<h3 class="panel-title" style="font-size: 16px; font-weight: normal; margin-bottom: 5px; padding-top: 5px; color: #555555;">
								<a style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
									<i class="ion-edit"></i>
									<?php if($location->name == $authenticated_locations[$current_logged_in_location_id]) { ?>
									<?php echo $location->name . ' ('. $cur_quantity .')'; ?> (<?php echo lang('common_current_location'); ?>)
									<?php } else {?>
									<?php echo $location->name . ' ('. $cur_quantity .')'; ?>
									<?php }?>
								</a>
							</h3>
						</div>
						<div id="collapse<?php echo $i;?>" class="panel-collapse collapse <?php if ($location->name == $authenticated_locations[$current_logged_in_location_id]) echo 'in';?>" role="tabpanel" aria-labelledby="heading<?php echo $i;?>">
							<div class="panel-body">
								<?php if ($this->Employee->has_module_action_permission('items','edit_quantity', $this->Employee->get_logged_in_employee_info()->person_id)) { ?>
        							<?php
        							if (!isset($is_clone))
        							{
        							?>
        							<div class="form-group quantity-input <?php if ($item_info->is_service){echo 'hidden';} ?>">
        							
        								<?php echo form_label(lang('items_current_quantity').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
        								<div class="col-sm-9 col-md-9 col-lg-10">
        									<h5 data-start-quantity="<?php echo $cur_quantity; ?>" class="cur_quantity" id="cur_quantity_location_<?php echo $location->location_id;?>"><?php echo $cur_quantity; ?></h5>
        								</div>
        							</div>
        							<?php
        							}
        							?>	
            
            						<div class="form-group quantity-input <?php if ($item_info->is_service){echo 'hidden';} ?>">
            						<?php echo form_label(lang('items_add_minus').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
            							<div class="col-sm-9 col-md-9 col-lg-10">
            							<?php echo form_input(array(
            								'name'=>'locations['.$location->location_id.'][quantity_add_minus]',
            								'value' => '',
            								'id' => 'quantity_add_minus_location_'.$location->location_id,
            								'data-location-id' => $location->location_id,
            								'class'=>'form-control form-inps quantity_add_minus',
            							));?>
            							</div>

            						</div>		
            						
            					<div class="form-group">
            						<h4 class="text-center"><?php echo lang('common_or') ?></h4>
            					</div>
            					
            					<div class="form-group quantity-input <?php if ($item_info->is_service){echo 'hidden';} ?>">
            					<?php echo form_label(lang('items_quantity').':', '', array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
            						<div class="col-sm-9 col-md-9 col-lg-10">
            		
            						<?php echo form_input(array(
            							'name'=>'locations['.$location->location_id.'][quantity]',
            							'value' => '',
            							'id' => 'quantity_location_'.$location->location_id,
            							'data-location-id' => $location->location_id,
            							'class'=>'form-control form-inps quantity',
            						));?>
            						</div>
            						<hr />
            					</div>		
            					<?php } ?>
							</div>
						</div>
					</div>
				<?php }?>
				</div>
				<?php echo form_hidden('redirect', isset($redirect) ? $redirect : ''); ?>
				<?php echo form_hidden('sale_or_receiving', isset($sale_or_receiving) ? $sale_or_receiving : ''); ?>
				
				<div class="form-actions">
					<?php
					if (isset($redirect) && $redirect == 1)
					{
						echo form_button(array(
					    'name' => 'cancel',
					    'id' => 'cancel',
						 'class' => 'submit_button btn btn-danger',
					    'value' => 'true',
					    'content' => lang('common_cancel')
						));
					
					}
					?>
					<?php
						echo form_submit(array(
							'name'=>'submitf',
							'id'=>'submitf',
							'value'=>lang('common_submit'),
							'class'=>'submit_button floating-button btn btn-primary')
						);
					?>
				</div>

				
				<div class="panel panel-piluku_unit">
					<div class="panel-heading">
		                <h3 class="panel-title">
		                    <i class="ion-edit"></i> Đơn Vị Tính
		                </h3>
		        	</div>
		        	<?php 
		        		if ($item_info->type_unit_formula != '') :
							$type_unit_formula = json_decode($item_info->type_unit_formula);

							foreach ($type_unit_formula as $unit => $unit_number): 
					?>
		        	<div class="add_unit_change">
			        	<div class="panel-body">
			        		<div class="form-group">
								<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Số Lượng Quy Đổi:</label>
								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="text" class="form-control" name="unit_number[]" value="<?php echo trim($unit_number) ?>">
								</div>
							</div>
							
							<div class="form-group">
								<?php echo form_label(lang('common_unit').':', 'unit_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
								<div class="col-sm-9 col-md-9 col-lg-10">
									<?php echo form_dropdown('unit_change[]', $units, trim($unit), 'class="form-control" id="unit_id_change"');?>
									<div>
										<?php echo anchor("items/manage_units",lang('common_manage_units'),array('target' => '_blank', 'title'=>lang('common_manage_units')));?>
									</div>
									
								</div>
							</div>						
			        	</div>
		        	</div>
		        	
		        		<?php endforeach; else: ?>

		        	<div class="add_unit_change">
			        	<div class="panel-body">
			        		<div class="form-group">
								<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Số Lượng Quy Đổi:</label>
								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="text" class="form-control" name="unit_number[]" >
								</div>
							</div>
							
							<div class="form-group">
								<?php echo form_label(lang('common_unit').':', 'unit_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide')); ?>
								<div class="col-sm-9 col-md-9 col-lg-10">
									<?php echo form_dropdown('unit_change[]', $units, $selected_unit ='', 'class="form-control" id="unit_id_change"');?>
									<div>
										<?php echo anchor("items/manage_units",lang('common_manage_units'),array('target' => '_blank', 'title'=>lang('common_manage_units')));?>
									</div>
									
								</div>
							</div>						
			        	</div>
		        	</div>

		        <?php endif; ?>

		        	<div class="form-group">
						<label for="attr_group_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Thêm Mới Quy Cách</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<button type="button" id="id123" class="btn btn-danger">Thêm Mới</button>
						</div>
					</div>
				</div>
								
				<!-- điều hướng -->
				<div class="item_navigation text-center">
					<ul class="list-inline">
						<li>
							<?php
							if (isset($prev_item_id) && $prev_item_id)
							{
								echo '<div class="previous_item">';
									echo anchor('items/view/'.$prev_item_id, '&laquo; '.lang('items_prev_item'), 'class="btn btn-green btn-round"');
								echo '</div>';
							}
							?>
						</li>
						<li>
							<?php
							if (isset($next_item_id) && $next_item_id)
							{
								echo '<div class="next_item">';
									echo anchor('items/view/'.$next_item_id,lang('items_next_item').' &raquo;', 'class="btn btn-green btn-round"');
								echo '</div>';
							}
							?>
						</li>
					</ul>
				</div><!-- /item_navigation -->
			</div><!-- /panel-body -->
		</div><!-- /panel -->
	</div>
</div>
	

<?php 
	$tst1 = '';
	foreach ($units as $key => $option ) {

	 $tst1 .= '<option value="'.$key.'">'.$option.'</option>';	 		
	}
?> 
	
<script type='text/javascript'>

$(document).ready(function(){

    $("#id123").click(function(){

        var content_add_unit = "";
        content_add_unit = "<div class='panel-body'>";
        content_add_unit += "<div class='form-group'>";
        content_add_unit += "<label for='attr_group_id' class='col-sm-3 col-md-3 col-lg-2 control-label wide'>Số Lượng Quy Đổi:</label>";
        content_add_unit += "<div class='col-sm-9 col-md-9 col-lg-10'>";
        content_add_unit += "<input type='text' class='form-control' name='unit_number[]'>";
        content_add_unit += "</div>";
        content_add_unit += "</div>";

        content_add_unit += "<div class='form-group'>";
        <?php echo "content_add_unit +='"; echo (form_label(lang('common_unit').':', 'unit_id',array('class'=>'col-sm-3 col-md-3 col-lg-2 control-label wide'))."'"); ?>;
        content_add_unit += "<div class='col-sm-9 col-md-9 col-lg-10'>";
        content_add_unit += '<select name="unit_change[]" class="form-control" id="unit_id_change">';
        <?php echo "content_add_unit +='"; echo $tst1."'"?>;
		content_add_unit += '</select>';
		content_add_unit += "</div>";
        content_add_unit += "</div>";
        content_add_unit += "</div>";
        $('.add_unit_change').append(content_add_unit);
    });
});



 // $("#btn2").click(function(){
 //        $("ol").append("<li>Appended item</li>");
 //    });

var SUPPLIERS = '<?php echo !empty($suppliers_formatted) ? json_encode($suppliers_formatted, 1) : '[]';?>';
var CUSTOMERS = '<?php echo !empty($customers_formatted) ? json_encode($customers_formatted, 1) : '[]';?>';

// insert function change add style unit ĐVT
function commission_change()
{
	if ($("#commission_type").val() == 'percent')
	{
		$("#commission-percent-calculation-container").show();
	}
	else
	{
		$("#commission-percent-calculation-container").hide();						
	}
}
$("#commission_type").change(commission_change);
$(document).ready(commission_change);

function get_taxes()
{
	var taxes = [];
	
	if (!$("#override_default_tax").prop('checked'))
	{
		var default_taxes = <?php echo json_encode($this->Item_taxes_finder->get_info($item_info->item_id)) ?>;
	
		for(var k = 0;k<default_taxes.length;k++)
		{
			taxes.push({'percent': parseFloat(default_taxes[k]['percent']), 'cumulative':default_taxes[k]['cumulative'] == 1});
		}	
	}
	else
	{
		var k=0;
		
		$('.tax-container.main input[name="tax_percents[]"]').each(function()
		{
			if ($(this).val())
			{
				taxes.push({'percent': parseFloat($(this).val()), 'cumulative': k==1 && $("#tax_cumulatives").prop('checked')});
			}
			
			k++;
		});	
	}
	return taxes;
	
}

function get_total_tax_percent()
{
	var total_tax_percent = 0;
	var taxes = get_taxes();
	for(var k = 0;k<taxes.length;k++)
	{
		total_tax_percent += parseFloat(taxes[k]['percent']);
	}
	
	return total_tax_percent;
}

function are_taxes_cumulative()
{
	var taxes = get_taxes();
	
	return (taxes.length == 2 && taxes[1].cumulative);
}

function calculate_margin_percent()
{
	if ($("#tax_included").prop('checked') )
	{
		var cost_price = parseFloat($('#cost_price').val());
		var unit_price = parseFloat($('#unit_price').val());

		var cumulative = are_taxes_cumulative();
		
		if (!cumulative)
		{
			//Margin amount
			//(100*.1)
			//100 + (100*.1) = 118.80 * .08 
	
			//cost price 100.00
			//8% tax
			//margin 10%
			//110.00 before tax
			//selling price 118.80
			//100 * 1.1 = profit 10%	
	
	
			// X = COST PRICE
			// Y = MARGIN PERCENT
			// Z = SELLING PRICE
			// Q = TAX PERCENT
			//100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);
	
			//X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
			//Y = -(100 ((Q+100) X-100 Z))/((Q+100) X) and (Q+100) X!=0

			var tax_percent = parseFloat(get_total_tax_percent());
		
			var Z = unit_price;
			var X = cost_price;
			var Q = tax_percent;
			var margin_percent = -(100*((Q+100)*X-100*Z))/((Q+100)*X);
		}
		else
		{
			var taxes = get_taxes();
			var tax_1 = 1+(taxes[0]['percent']/100);
			var tax_2 = 1+(taxes[1]['percent']/100);
			margin_percent = (unit_price / (cost_price * tax_1 * tax_2) - 1) * 100;
		}

	}
	else
	{
		var cost_price = parseFloat($('#cost_price').val());
		var unit_price = parseFloat($('#unit_price').val());
		var margin_percent =  -100 + (100*(unit_price/cost_price));
	}

	margin_percent = parseFloat(Math.round(margin_percent * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
	
	$('#margin').val(margin_percent + '%');
}
function calculate_margin_price()
{		
	if ($("#tax_included").prop('checked') )
	{		
		var cost_price = parseFloat($('#cost_price').val());
		var margin_percent = parseFloat($("#margin").val());
		
		var cumulative = are_taxes_cumulative();
		
		if (!cumulative)
		{
			//Margin amount
			//(100*.1)
			//100 + (100*.1) = 118.80 * .08 
	
			//cost price 100.00
			//8% tax
			//margin 10%
			//110.00 before tax
			//selling price 118.80
			//100 * 1.1 = profit 10%	
	
	
			// X = COST PRICE
			// Y = MARGIN PERCENT
			// Z = SELLING PRICE
			// Q = TAX PERCENT
			//100 * (1+ (10/100)) = 118.80 - (100 * (1+ (10/100)) * 8/100);
	
			//X * (1+Y/100) = Z - (X * (1+(Y/100)) * Q/100)
			//Z = (Q X Y+100 Q X+100 X Y+10000 X)/10000
			
			var tax_percent = get_total_tax_percent();
				
			var X = cost_price;
			var Y = margin_percent;
			var Q = tax_percent;
		
			var margin_price = (Q*X*Y+100*Q*X+100*X*Y+10000*X)/10000;		
		}
		else
		{
			var marked_up_price_before_tax = cost_price * (1+(margin_percent/100));
			
			var taxes = get_taxes();
			var cumulative_tax_percent = taxes[1]['percent'];
			
			var first_tax = (marked_up_price_before_tax*(taxes[0]['percent']/100));
			var second_tax = (marked_up_price_before_tax + first_tax) *(taxes[1]['percent']/100);
			var margin_price = marked_up_price_before_tax + first_tax + second_tax;
		}
		
		margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
	}
	else
	{
		var cost_price = parseFloat($('#cost_price').val());
		var margin_percent = parseFloat($("#margin").val());

		var margin_price = cost_price + (cost_price / 100 * (margin_percent));
		margin_price = parseFloat(Math.round(margin_price * 100) / 100).toFixed(<?php echo json_encode($decimals); ?>);
		
	}

	$('#unit_price').val(margin_price);
}

var validator;

$(document).ready(function()
{	
	$('#image_id').itemImagePreview({ selector : '#image_preview' }); // Custom preview container
	
	$("#is_serialized").change(function()
	{
		if ($(this).prop('checked'))
		{
			$("#serial_container").removeClass('hidden');
		}
		else
		{
			$("#serial_container").addClass('hidden');			
		}
	});
	
	$(".delete_serial_number").click(function()
	{
		$(this).parent().parent().remove();
	});
	
	$("#add_serial_number").click(function()
	{
		$("#serial_numbers tbody").append('<tr><td><input type="text" class="form-control form-inps" size="40" name="serial_numbers[]" value="" /></td><td><input type="text" class="form-control form-inps" size="20" name="serial_number_prices[]" value="" /></td><td>&nbsp;</td></tr>');
	});
	
	
	$(".quantity_add_minus").keyup(function()
	{
		if ($(this).val() != '')
		{
			var quantity = $(this).parent().parent().next().find('.quantity');
			quantity.val('');
		
			var location_id = $(this).data('location-id');

			var start_quantity = parseFloat($('#cur_quantity_location_'+location_id).data('start-quantity'));
		
			if (!isNaN(parseFloat($(this).val())) && isFinite($(this).val()) && parseFloat($(this).val())!=0)
			{
				var quantity_info = parseFloat($(this).val()) > 0 ? '<span class="text-success">+'+$(this).val()+'</span>' : '<span class="text-danger">'+$(this).val()+'</span>';
				$('#cur_quantity_location_'+location_id).html((start_quantity+parseFloat($(this).val())) + " ("+quantity_info+")");
				var quantity_input_post = 	parseFloat($(this).val()) > 0 ? $(this).val() : $(this).val();
			}
			else
			{
				$('#cur_quantity_location_'+location_id).text($('#cur_quantity_location_'+location_id).data('start-quantity'));			
			}
			//alert(quantity_input_post);
		}
	});
	
	$(".quantity").keyup(function()
	{
		if ($(this).val() != '')
		{
			var quantity_add_minus = $(this).parent().parent().prev().find('.quantity_add_minus');
			quantity_add_minus.val('');
		
			var location_id = $(this).data('location-id');
			var start_quantity = parseFloat($('#cur_quantity_location_'+location_id).data('start-quantity'));
		
			if (!isNaN(parseFloat($(this).val())) && isFinite($(this).val()) && parseFloat($(this).val())!=0)
			{
				var quantity_info = (parseFloat($(this).val())-start_quantity) > 0 ? '<span class="text-success">+'+(parseFloat($(this).val())-start_quantity)+'</span>' : '<span class="text-danger">'+(parseFloat($(this).val())-start_quantity)+'</span>';
				$('#cur_quantity_location_'+location_id).html((parseFloat($(this).val())) + " ("+quantity_info+")");
				var quantity_input_post = 	(parseFloat($(this).val())-start_quantity) > 0 ? (parseFloat($(this).val())-start_quantity) : (parseFloat($(this).val())-start_quantity);	
			}
			else
			{
				$('#cur_quantity_location_'+location_id).text($('#cur_quantity_location_'+location_id).data('start-quantity'));			
			}
		}
	});
	
	<?php if ($this->config->item('enable_margin_calculator')) { ?>
	
	if ($('#unit_price').val() && $('#cost_price').val())
	{
		calculate_margin_percent();
	}
	
	$('#margin, #cost_price,.tax-container.main input[name="tax_percents[]"]').keyup(function()
	{
		if($("#margin").val() != '')
		{
			calculate_margin_price();
		}
	});
	
	<?php } ?>
	
	$('#supplier_id').selectize();
	// add customers 
	$('#customers_id').selectize();

	$('#category_id').selectize({
		create: true,
		render: {
	      option_create: function(data, escape) {
				var add_new = <?php echo json_encode(lang('common_new_category')) ?>;
	        return '<div class="create">'+escape(add_new)+' <strong>' + escape(data.input) + '</strong></div>';
	      }
		}
	});
	$(".delete_item_number").click(function()
	{
		$(this).parent().parent().remove();
	});
	
	$("#add_addtional_item_number").click(function()
	{
		$("#additional_item_numbers tbody").append('<tr><td><input type="text" class="form-control form-inps" size="40" name="additional_item_numbers[]" value="" /></td><td>&nbsp;</td></tr>');
	});	
	
	
	$("#cancel").click(cancelItemAddingFromSaleOrRecv);
	
    setTimeout(function(){$(":input:visible:first","#item_form").focus();},100);
		
	date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);
   	
	$(".override_default_tax_checkbox, .override_prices_checkbox, .override_default_commission").change(function()
	{
		$(this).parent().parent().next().toggleClass('hidden')
	});
	
	$("#is_service").change(function()
	{
		if ($(this).prop('checked'))
		{
			$(".quantity-input").addClass('hidden');			
			$(".reorder-input").addClass('hidden');			
		}
		else
		{
			$(".quantity-input").removeClass('hidden');
			$(".reorder-input").removeClass('hidden');
		}
	});

	$('#suppliers').selectize({
	    plugins: ['remove_button'],
		delimiter: ',',
		loadThrottle : 215,
		persist: false,
		valueField: 'person_id',
		labelField: 'label',
		searchField: 'label',
		options: JSON.parse(SUPPLIERS)
	});

	// add customers
	$('#customers').selectize({
	    plugins: ['remove_button'],
		delimiter: ',',
		loadThrottle : 215,
		persist: false,
		valueField: 'person_id',
		labelField: 'label',
		searchField: 'label',
		options: JSON.parse(CUSTOMERS)
	});
	// end customers
	
	$('#tags').selectize({
	    plugins: ['remove_button'],
		delimiter: ',',
		loadThrottle : 215,
		persist: false,
		valueField: 'value',
		labelField: 'label',
		searchField: 'label',
		create: true,
		render: {
	      option_create: function(data, escape) {
				var add_new = <?php echo json_encode(lang('common_add_new_tag')) ?>;
	        return '<div class="create">'+escape(add_new)+' <strong>' + escape(data.input) + '</strong></div>';
	      }
		},
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url:'<?php echo site_url("items/tags");?>'+'?term='+encodeURIComponent(query),
				type: 'GET',
				error: function() {
					callback();
				},
				success: function(res) {
					res = $.parseJSON(res);
					callback(res);
				}
			});
		}
	});
	validator = $('#item_form').validate({
		ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
		submitHandler:function(form)
		{
			$.post('<?php echo site_url("items/check_duplicate");?>', {term: $('#name').val()},function(data) {
			<?php if(!$item_info->item_id) {  ?>
				if(data.duplicate)
				{
					bootbox.confirm(<?php echo json_encode(lang('common_items_duplicate_exists'));?>, function(result)
					{
						if(result)
						{
							doItemSubmit(form);
						}
					});
				}
				else
				{
					doItemSubmit(form);
				}
				<?php } else { ?>
					doItemSubmit(form);
				<?php } ?>
				} , "json")
				.error(function() {
				});
		},
		errorClass: "text-danger",
		errorElement: "span",
			highlight:function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			},
		rules:
		{
		<?php if(!$item_info->item_id) {  ?>
			item_number:
			{
				remote: 
				    { 
					url: "<?php echo site_url('items/item_number_exists');?>", 
					type: "post"
					
				    } 
			},
			product_id:
			{
				remote: 
				    { 
					url: "<?php echo site_url('items/product_id_exists');?>", 
					type: "post"
					
				    } 
			},
			supplier_id:"required",
		<?php } ?>
		
		<?php foreach($tiers as $tier) { ?>
			"<?php echo 'item_tier['.$tier->id.']'; ?>":
			{
				number: true
			},
		<?php } ?>
		
		<?php foreach($locations as $location) { ?>
			"<?php echo 'locations['.$location->location_id.'][quantity]'; ?>":
			{
				number: true
			},
			"<?php echo 'locations['.$location->location_id.'][reorder_level]'; ?>":
			{
				number: true
			},
			"<?php echo 'locations['.$location->location_id.'][cost_price]'; ?>":
			{
				number: true
			},
			"<?php echo 'locations['.$location->location_id.'][unit_price]'; ?>":
			{
				number: true
			},			
			"<?php echo 'locations['.$location->location_id.'][promo_price]'; ?>":
			{
				number: true
			},			
			<?php foreach($tiers as $tier) { ?>
				"<?php echo 'locations['.$location->location_id.'][item_tier]['.$tier->id.']'; ?>":
				{
					number: true
				},
			<?php } ?>			
			
		<?php } ?>
		
			name:"required",
			product_id:"required",
			category_id:"required",
			cost_price:
			{
				required:false,
				number:true
			},

			unit_price:
			{
				required:false,
				number:true
			},
			promo_price:
			{
				number: true
			},
			reorder_level:
			{
				number:true
			}
		},
		messages:
		{			
			<?php if(!$item_info->item_id) {  ?>
			item_number:
			{
				remote: <?php echo json_encode(lang('items_item_number_exists')); ?>
				   
			},
			product_id:
			{
				remote: <?php echo json_encode(lang('items_product_id_exists')); ?>
				   
			},
			<?php } ?>
			
			<?php foreach($tiers as $tier) { ?>
				"<?php echo 'item_tier['.$tier->id.']'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},
			<?php } ?>
			
			<?php foreach($locations as $location) { ?>
				"<?php echo 'locations['.$location->location_id.'][quantity]'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},
				"<?php echo 'locations['.$location->location_id.'][reorder_level]'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},
				"<?php echo 'locations['.$location->location_id.'][cost_price]'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},
				"<?php echo 'locations['.$location->location_id.'][unit_price]'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},			
				"<?php echo 'locations['.$location->location_id.'][promo_price]'; ?>":
				{
					number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
				},			
				<?php foreach($tiers as $tier) { ?>
					"<?php echo 'locations['.$location->location_id.'][item_tier]['.$tier->id.']'; ?>":
					{
						number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
					},
				<?php } ?>				
			<?php } ?>
			
			name:<?php echo json_encode(lang('common_item_name_required')); ?>,
			supplier_id: <?php echo json_encode(lang('items_must_select_supplier'));?>,
			category_id:<?php echo json_encode(lang('common_category_required')); ?>,
			cost_price:
			{
				required:<?php echo json_encode(lang('items_cost_price_required')); ?>,
				number:<?php echo json_encode(lang('common_cost_price_number')); ?>
			},
			unit_price:
			{
				required:<?php echo json_encode(lang('items_unit_price_required')); ?>,
				number:<?php echo json_encode(lang('common_unit_price_number')); ?>
			},
			promo_price:
			{
				number: <?php echo json_encode(lang('common_this_field_must_be_a_number')); ?>
			}
		}
	});
});

var submitting = false;

function doItemSubmit(form)
{
	if (submitting) return;
	submitting = true;
$('#grid-loader').show();
	$(form).ajaxSubmit({
	success:function(response)
	{
$('#grid-loader').hide();
		submitting = false;		
		show_feedback(response.success ? 'success' : 'error', response.message,response.success ? <?php echo json_encode(lang('common_success')); ?> +' #' + response.item_id : <?php echo json_encode(lang('common_error')); ?>);
		
		if(response.redirect==1 && response.success)
		{ 
			if (response.sale_or_receiving == 'sale')
			{
				$.post('<?php echo site_url("sales/add");?>', {item: response.item_id}, function()
				{
					window.location.href = '<?php echo site_url('sales/index/1'); ?>';
				});
			}
			else
			{
				$.post('<?php echo site_url("receivings/add");?>', {item: response.item_id}, function()
				{
					window.location.href = '<?php echo site_url('receivings'); ?>';
				});
			}
		}
		else if(response.redirect==2 && response.success)
		{
			window.location.href = '<?php echo site_url('items'); ?>';
		}
		else
		{
			$(".form-group").removeClass('has-success has-error');
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}

		
		<?php if(!$item_info->item_id) { ?>
		//If we have a new item, make sure we hide the tax containers to "reset"
		$(".tax-container").addClass('hidden');
		$(".item-location-price-container").addClass('hidden');
		$('.commission-container').addClass('hidden');
		
		//Make the quantity inputs show up again in case they were hidden
		$(".quantity-input").removeClass('hidden');
		$(".reorder-input").removeClass('hidden');
		
		var selectize = $("#tags")[0].selectize;
		selectize.clear();
		selectize.clearOptions();
		validator.resetForm();
		
		<?php } ?>
	},
	<?php if(!$item_info->item_id) { ?>
	resetForm: true,
	<?php } ?>
	dataType:'json'
	});
}

function cancelItemAddingFromSaleOrRecv()
{
	bootbox.confirm(<?php echo json_encode(lang('items_are_you_sure_cancel')); ?>, function(result)
	{
		if (result)
		{
			<?php if (isset($sale_or_receiving) && $sale_or_receiving == 'sale') {?>
				window.location = <?php echo json_encode(site_url('sales')); ?>;
			<?php } else { ?>
				window.location = <?php echo json_encode(site_url('receivings')); ?>;
			<?php } ?>
		}
	});
}

//new image preview
(function($){
	$.fn.itemImagePreview = function(params){
		$(this).change(function(evt){
			$(params.selector).html('');
			if(typeof FileReader == "undefined") return true; // File reader not available.

			var fileInput = $(this);
			var files = evt.target.files; // FileList object

			// Loop through the FileList and render image files as thumbnails.
			for (var i = 0, f; f = files[i]; i++) {

				// Only process image files.
				if (!f.type.match('image.*')) {
					continue;
				}

				var reader = new FileReader();
				var j = 0;
				// Closure to capture the file information.
				reader.onload = (function(theFile) {
					return function(e) {
						
						// Render thumbnail.
						var panelTemplateTop = 
						//'<div class="col-lg-4 col-md-4 col-xs-12">' +
							//'<div class="panel panel-default panel-equal">' +
								//'<div class="panel-heading">' + <?php echo json_encode("Image Preview") ?> + ' <i class="glyphicon glyphicon-eye-open pull-right"></i></div>' +
									//'<div class="panel-body">' + 
										'<div class="thumbnail item_image_preview_thumb">';
						
						var panelTemplateBottom = 
									//'</div>' +
								//'</div>' + 
							//'</div>' +
						'</div>';
										
						var columnTemplate = panelTemplateTop + 
								'<img class="file-input-thumb" width="150" src="' + e.target.result + '" title="' + theFile.name + '"/>' +
								panelTemplateBottom;
								
						
						if(j % 3 == 0)
						{
							//var rowTemplate = '<div class="row">';
							//$(params.selector).append(rowTemplate)
						}
						
						$(params.selector).append(columnTemplate);
						//$(params.selector).find('.row').last().append(columnTemplate);
						j++;
					};
				})(f);

				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			}
		});
	};
})(jQuery);

</script>
<?php echo form_close(); ?>
</div>
<?php $this->load->view('partial/footer'); ?>
