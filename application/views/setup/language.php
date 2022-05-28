<?php
	$lvs_user_role_id = $this->session->userdata('lvs_user_role_id');
	$role_r = $this->Crud->module($lvs_user_role_id, 'Setup:Language', 'read');
?>

<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> <?php echo _ph('language_setup');?> </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><?php echo _ph('dashboard');?></li>
                    <li><?php echo _ph('setup');?></li>
                    <li><a class="link-effect" href="<?php echo base_url('setup/language'); ?>"><?php echo _ph('language_setup');?></a></li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="content content-narrow">
       	<div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="block">
                            <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs">
                                <?php if(isset($edit_profile)):?>
                                <li class="active"><a href="#tab_edit"><i class="si si-wrench"></i> <?php echo _ph('edit_phrase');?></a></li>
                                <?php endif;?>
                                <li class="<?php if(!isset($edit_profile))echo 'active';?>"><a href="#tab_list"><i class="si si-list"></i> <?php echo _ph('language_list');?></a></li>
                                <li class=""><a href="#tab_phrase"><i class="si si-plus"></i> <?php echo _ph('add_phrase');?></a></li>
                                <li class=""><a href="#tab_language"><i class="si si-plus"></i> <?php echo _ph('add_language');?></a></li>
                            </ul>
                            
                            <div class="block-content tab-content">
                                <?php if (isset($edit_profile)): ?>
                                <div class="tab-pane fade fade-up active in" id="tab_edit">
                                    <div class=""><br />
                                        <?php 
                                            $current_editing_language	=	$edit_profile;
                                            echo form_open(base_url('setup/language/update_phrase/'.$current_editing_language), array('id' => 'phrase_form'));
                                            $count = 1;
                                            $language_phrases	=	$this->db->query("SELECT `id` , `phrase` , `$current_editing_language` FROM `lv_language`")->result_array();
                                            foreach($language_phrases as $row) {
                                                $count++;
                                                $phrase_id			=	$row['id'];					//id number of phrase
                                                $phrase				=	$row['phrase'];						//basic phrase text
                                                $phrase_language	=	$row[$current_editing_language];	//phrase of current editing language
                                            ?>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="phrase<?php echo $row['id'];?>" id="phrase<?php echo $row['id'];?>" value="<?php echo $phrase_language;?>">
                                                            <label for="phrase<?php echo $row['id'];?>" class="text-primary"><?php echo $row['phrase'];?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            
                                            <input type="hidden" name="total_phrase" value="<?php echo $count;?>" />
                                            
                                            <div class="col-sm-12 text-center">
                                                <hr/>
                                                <button type="submit" class="btn btn-primary btn-sm btn-rounded" onClick="document.getElementById('phrase_form').submit();"><i class="fa fa-save"></i> <?php echo _ph('update_phrase');?></button>
                                            </div>	
                                            <?php
                                            echo form_close();
                                            ?>
                                    </div>
                                </div>
                                <?php endif;?>
                                
                                <div class="tab-pane fade fade-up <?php if(!isset($edit_profile))echo 'active';?> in" id="tab_list">
                                    <div class="col-sm-6"><br />
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th><?php echo _ph('language');?></th>
                                                    <th><?php echo _ph('option');?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                        $fields = $this->db->list_fields('language');
                                                        foreach($fields as $field)
                                                        {
                                                             if($field == 'id' || $field == 'phrase')continue;
                                                            ?>
                                                <tr>
                                                    <td><?php echo ucwords($field);?></td>
                                                    <td>
                                                        <a href="<?php echo base_url();?>setup/language/edit_phrase/<?php echo $field;?>"
                                                             class="btn btn-primary btn-sm">
                                                                <i class="si si-pencil"></i> <?php echo _ph('edit_phrase');?>
                                                        </a>
                                                        <a href="<?php echo base_url();?>setup/language/delete_language/<?php echo $field;?>"
                                                            rel="tooltip" data-placement="top" data-original-title="<?php echo _ph('delete_language');?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete Language ?');">
                                                                <i class="si si-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_phrase">
                                    <div class="col-sm-4"><br />
                                        <?php echo form_open(base_url('setup/language/add_phrase/'), array('class' => 'form-horizontal form-groups-bordered validate'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="phrase" required>
                                                            <label for="field-2"><?php echo _ph('phrase');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('add_phrase');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade fade-up" id="tab_language">
                                    <div class="col-sm-4"><br />
                                        <?php echo form_open(base_url('setup/language/add_language/'), array('class' => 'form-horizontal form-groups-bordered validate'));?>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <div class="form-material">
                                                            <input type="text" class="form-control" name="language" required>
                                                            <label for="field-2"><?php echo _ph('language');?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-save"></i> <?php echo _ph('add_language');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
