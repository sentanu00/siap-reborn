<section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
              	<div class="box-header with-border">
                  <h3 class="box-title"><?php echo $pageTitle ;?></h3>
                   <div class="box-body">

	<div class="page-content-wrapper m-t">
    
<div class="sbox animated fadeIn">
	<div class="sbox-content">	
 	
	<?php echo $this->session->flashdata('message'); ?>
		<div class="block-content" style="margin:10px">


			<div class="tab-content m-t">
			  <div class="tab-pane active use-padding" id="info">
			 <form class="form-horizontal row" action="<?php echo site_url('sximo/config/postSave');?>" method="post">

				<div class="col-sm-6">
				<fieldset > <legend><?php echo $this->lang->line('core.fr_generalinfo'); ?> </legend>

				  <div class="form-group">
					<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_appname'); ?> </label>
					<div class="col-md-8">
					<input name="cnf_appname" type="text" id="cnf_appname" class="form-control input-sm" required  value="<?php echo  CNF_APPNAME ;?>" readonly />
					 </div>
				  </div>

				  <div class="form-group">
					<label for="ipt" class=" control-label col-md-4">Nama Perusahaan </label>
					<div class="col-md-8">
					<input name="cnf_namaperusahaan" type="text" id="cnf_namaperusahaan" class="form-control input-sm" value="<?php echo CNF_NAMAPERUSAHAAN ;?>" />
					 </div>
				  </div>

				  <div class="form-group">
					<label for="ipt" class=" control-label col-md-4">Nama PG </label>
					<div class="col-md-8">
					<input name="cnf_pg" type="text" id="cnf_pg" class="form-control input-sm" value="<?php echo  CNF_PG ;?>" />
					 </div>
				  </div>

				  <div class="form-group">
					<label for="ipt" class=" control-label col-md-4">Alamat </label>
					<div class="col-md-8">
					<input name="cnf_alamat" type="text" id="cnf_alamat" class="form-control input-sm" value="<?php echo  CNF_ALAMAT ;?>" />
					 </div>
				  </div>


			   <div class="form-group">
				<label for="ipt" class=" control-label col-md-4"><?php echo $this->lang->line('core.fr_frontendtemplate'); ?> </label>
				<div class="col-md-8">
						<select class="form-control" name="cnf_theme">
						<?php foreach($themes as $theme) {?>
							<option value="<?php echo $theme['folder'];?>" <?php if($theme['folder'] == CNF_THEME) echo 'selected="selected"';?>><?php echo $theme['name'];?></option>
						<?php } ?>
						</select>
				 </div>
			  </div>

 		  <div class="form-group">
			<label for="ipt" class=" control-label col-sm-4"><?php echo $this->lang->line('core.fr_multilang'); ?> </label>
			<div class="col-sm-8">
					<label class="checkbox">
					<input type="checkbox" name="cnf_multilang" value="true"  <?php if(CNF_MULTILANG =='true') echo 'checked';?>/>
					<?php echo $this->lang->line('core.enable'); ?>
					</label>
			</div>
		</div>

		<div class="form-group">
				<label for="ipt" class=" control-label col-md-4">KEY TOKEN</label>
				<div class="col-md-8">
						<input name="cnf_keysync" type="text" id="cnf_keysync" class="form-control input-sm" value="<?php echo  CNF_KEYSYNC ;?>" />
				 </div>
			  </div>


			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">GENERAL MANAGER</label>
				<div class="col-md-8">
						<input name="cnf_gm" type="text" id="cnf_gm" class="form-control input-sm" value="<?php echo  CNF_GM ;?>" />
				 </div>
			  </div>


			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">MANAGER PENGOLAHAN</label>
				<div class="col-md-8">
						<input name="cnf_manpengolahan" type="text" id="cnf_manpengolahan" class="form-control input-sm" value="<?php echo  CNF_MANPENGOLAHAN ;?>" />
				 </div>
			  </div>

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">MANAGER TANAMAN</label>
				<div class="col-md-8">
						<input name="cnf_mantanaman" type="text" id="cnf_mantanaman" class="form-control input-sm" value="<?php echo  CNF_MANTANAMAN ;?>" />
				 </div>
			  </div>

			</fieldset>

		
	</div>

	<div class="col-sm-6">


			<fieldset > <legend>Setting Aplikasi </legend>

		 <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Company Code</label>
				<div class="col-md-8">
						<input name="cnf_companycode" type="text" id="cnf_companycode" class="form-control input-sm" value="<?php echo  CNF_COMPANYCODE ;?>" />
				 </div>
			  </div>
		<div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Plant Code</label>
				<div class="col-md-8">
						<input name="cnf_plancode" type="text" id="cnf_plancode" class="form-control input-sm" value="<?php echo  CNF_PLANCODE ;?>" />
				 </div>
			  </div>
		<div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Tahun Tanam</label>
				<div class="col-md-8">
						<input name="cnf_tahuntanam" type="text" id="cnf_tahuntanam" class="form-control input-sm" value="<?php echo  CNF_TAHUNTANAM ;?>" />
				 </div>
			  </div>
			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Tahun Giling</label>
				<div class="col-md-8">
						<input name="cnf_tahungiling" type="text" id="cnf_tahungiling" class="form-control input-sm" value="<?php echo  CNF_TAHUNGILING ;?>" />
				 </div>
			  </div>
			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Metode Analisa Rendemen</label>
				<div class="col-md-8">
						<select id="cnf_metode" name="cnf_metode" class="form-control input-sm">
							<option value="1" <?php if(CNF_METODE == 1) echo 'selected';?> >ARI</option>
							<option value="2" <?php if(CNF_METODE == 2) echo 'selected';?> >Core Sapler</option>
						</select>
				 </div> 
			  </div>

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Konsep Analisa Rendemen</label>
				<div class="col-md-8">
						<select id="cnf_konsep" name="cnf_konsep" class="form-control input-sm">
							<option value="1" <?php if(CNF_KONSEP == 1) echo 'selected';?> >Jombang Method</option>
							<option value="2" <?php if(CNF_KONSEP == 2) echo 'selected';?> >Jatiroto Method</option>
							<option value="3" <?php if(CNF_KONSEP == 3) echo 'selected';?> >Kedawung Method</option>
						</select>
				 </div> 
			  </div>
			  
			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Potongan Rafaksi (%)</label>
				<div class="col-md-8">
						<select id="cnf_rafaksi" name="cnf_rafaksi" class="form-control input-sm">
							<option value="1" <?php if(CNF_RAFAKSI == 1) echo 'selected';?> >Ya</option>
							<option value="0" <?php if(CNF_RAFAKSI == 0) echo 'selected';?> >Tidak</option>
						</select>
				 </div> 
			  </div>
			  
			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">SPTA Per Halaman</label>
				<div class="col-md-8">
						<select id="cnf_hal" name="cnf_hal" class="form-control input-sm">
							<option value="1" <?php if(CNF_HAL == 1) echo 'selected';?> >1 Spta Per halaman</option>
							<option value="2" <?php if(CNF_HAL == 2) echo 'selected';?> >2 Spta Per halaman</option>
							<option value="3" <?php if(CNF_HAL == 3) echo 'selected';?> >3 Spta Per halaman</option>
						</select>
				 </div> 
			  </div>

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Mutu Tebu Terbakar</label>
				<div class="col-md-8">
						<select id="cnf_mutu_terbakar" name="cnf_mutu_terbakar" class="form-control input-sm">
						</select>
				 </div> 
			  </div>


		  </fieldset>


				<div class="form-group">
				<label for="ipt" class=" control-label col-md-4"> </label>
				<div class="col-md-8">
					<button class="btn btn-primary" type="submit"><?php echo $this->lang->line('core.sb_savechanges'); ?> </button>
				 </div>
			  </div>

	</div>
</form>
</div>
</div>
	</div>
</div>	

</div>
</div>
</div>
</div>
</div>
</div>
</div>
        </section>
<script type="text/javascript">
	
	$(document).ready(function(){
		$("#cnf_mutu_terbakar").jCombo("<?php echo site_url('mjabatan/comboselect?filter=m_rafaksi:nilai:nilai') ?>",
		{  selected_value : '<?php echo CNF_MUTU_TERBAKAR;?>' });
	});

</script>




