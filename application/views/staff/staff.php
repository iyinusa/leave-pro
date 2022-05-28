<main id="main-container">
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading"> <?php echo _ph('staff'); ?> </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><?php echo _ph('dashboard'); ?></li>
                    <li><a class="link-effect" href="<?php echo base_url('staff'); ?>"><?php echo _ph('staff'); ?></a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content content-narrow">
        <div class="block">
            <div class="block-header">
                <h3 class="block-title">
                    <?php echo _ph('staff'); ?>
                    
                    <?php if($role_c == 1){ ?>
                        <a href="javascript:;" class="btn btn-primary btn-sm pull-right pop" pageTitle="<?php echo _ph('add_staff'); ?>" pageName="<?php echo base_url('staff/manage'); ?>" pageSize="modal-lg">
                        <i class="fa fa-plus-circle"></i> <?php echo _ph('add'); ?></a>
                    <?php } ?>
                </h3>
            </div>
            <div class="block-content table-responsive">
                <div class="">
                    <table id="dtable" class="table table-striped table-bordered responsive small">
                        <thead>
                            <tr>
                                <th><?php echo _ph('staff'); ?> ID</th>
                                <th><?php echo _ph('staff'); ?></th>
                                <th><?php echo _ph('department'); ?></th>
                                <th><?php echo _ph('contact'); ?></th>
                                <th><?php echo _ph('role'); ?></th>
                                <th><?php echo _ph('status'); ?></th>
                                <th width="120px"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
